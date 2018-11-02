<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product as Product;
use App\Category as Category;
use App\Configuration as Configuration;
use App\Banner as Banner;
use App\Product_Attribute_Assoc as Product_Attribute_Assoc;
use App\UserAddress as UserAddress;
use App\Coupon as Coupon;
use App\UserOrder as UserOrder;
use App\OrderDetail as OrderDetail;
use Cart;
use Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->banners='App\Banner'::where('status','1')->get();
        $this->configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
        
        $this->parent_categories='App\Category'::where(['status'=>'1','parent_id'=>null])->get();

       
    }




    /*

    Home page for authenticated user

     */
      public function index(Request $request){

        $products=Product::with('get_images')->where(['future'=>'1','status'=>'1'])->get();
       
        
        return view('index',['banners'=>$this->banners,'configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'featured_items'=>$products]);
    }

    /*
        ACcounts view:All details related to user-personal and address.
        Input:user id
        Output: user,user addresses


    */
      public function showAccountsPage(Request $request){

        $user_address=UserAddress::where('user_id',$request->user()->id)->get();

        return view('frontend.account_details',['configurations'=>$this->configuration,'user_address'=>$user_address]);

    }
    /*
      Store user address 

    */
    public function storeAddress(Request $request, $id){
        

        $request->validate([
        'address1'=>'required|max:100',
        'address2'=>'max:100',
        'state'=>'required|max:45',
        'city'=>'required|max:45',
        'country'=>'required|max:45',
        'zipcode'=>'required|max:6']);

        $user_address=UserAddress::create(['user_id'=>$request->user()->id,'address1'=>$request->address1,'address2'=>$request->address2,'state'=>$request->state,'city'=>$request->city,'country'=>$request->country,'zipcode'=>$request->zipcode]);

       

        $user_address->save();

        Session::flash('success','Address saved!!');
        return back();

    }
    /*

    Add Items to the cart
    Input:product id,quantity
    Output:Create a cart object using details
    */
    public function addItemToCart(Request $request,$id){
     
      //get product
      $product=Product::with('get_images')->findOrFail($id);


      //check if the quantity entered is null or 0

      if($request->quantity==null || $request->quantity==0){
      return back()->withInput($request->input())->withErrors('Min unit needs to be 1');
        }
      //to check if the product exists in cart 

      $cart_product=Cart::content()->groupBy('id')->get($id);

      //if not present check the quantity requested with the entered one. If present then compare with quantity requested and entered.

      if($cart_product==null){
       if($request->quantity>$product->quantity){
        return back()->withInput($request->input())->withErrors('Only '.$product->quantity.'units are available');
        }
      }
      else if(($request->quantity+($cart_product->first()->qty))>$product->quantity ){
        return back()->withInput($request->input())->withErrors('Only '.$product->quantity.'units are available');
            }
      if($product->special_price_from && $product->special_price_to){
        $date=date('Y-m-d');
        if($date<=$product->special_price_to && $date>=$product->special_price_from){
    
          $product->price=$product->special_price;

      }
    }
      Cart::add(['id'=>$product->id,'name'=>$product->name,'qty'=>$request->quantity,'price'=>$product->price,'options'=>['image'=>$product->get_images->first()->image_name]]);
      session(['cart_total'=>round((float)str_replace(',', '', Cart::total()),2)]);

      Session::flash('success','Item added to cart!');
      return back();

    }


    /*

      Cart Page view. All the contents in the cart are displayed.


    */

    public function showCart(Request $request){

      $cart_items=Cart::content();
      return view('frontend.cart',['configurations'=>$this->configuration,'cart_items'=>$cart_items]);

    }

    /*
    Update cart details on any change in quantity.
    Input:product id,qty,rowid of the cart object
    Update: Update cart object,recompute discount if any and update cart_total in seesion
    */

    public function updateCart(Request $request){

      $product=Product::findOrFail($request->productId);
      if($request->qty==null || $request->qty==0){

      return back()->withInput($request->input())->withErrors('Min unit needs to be 1');
    }
      if($request->qty<=$product->quantity){
        $item=Cart::update($request->rowId,['qty'=>$request->qty]);
        if(session()->has('percent_off')){
          $discount=(session()->get('percent_off'))*0.01*((float)str_replace(',', '', Cart::subtotal())+(float)str_replace(',', '', Cart::tax()));
          session(['discount'=>round($discount,2)]);
        }
        session(['cart_total'=>round((float)str_replace(',', '', Cart::total())-$discount,2)]);
        echo json_encode([$item,session()->get('discount'),(float)str_replace(',', '', Cart::subtotal()),(float)str_replace(',', '', Cart::tax()),session()->get('cart_total')]);
      }
      else{
            if(session()->has('percent_off')){
              $discount=(session()->get('percent_off'))*0.01*((float)str_replace(',', '', Cart::subtotal())+(float)str_replace(',', '', Cart::tax()));
              session(['discount'=>round($discount,2)]);
              session(['cart_total'=>round((float)str_replace(',', '', Cart::total())-$discount,2)]);
        }
            echo json_encode([Cart::get($request->rowId),session()->get('discount'),(float)str_replace(',', '', Cart::subtotal()),(float)str_replace(',', '', Cart::tax()),session()->get('cart_total')]);
      }
   
    
      
  }

  /*

  Delete cart object
  Input:rowid
  */

  public function deleteCart(Request $request){
    Cart::remove($request->rowId);
    if(Cart::count()==0){
      session(['discount'=>0]);
    }
    Session::flash('success','Item delted!');
    return redirect()->route('accounts.get_cart');

  }

/*

Compute discount and update cart_total
Input:coupon_id

*/

  public function getDiscount(Request $request){

    
    $coupon=Coupon::where('code',$request->coupon)->first();
    if(count($coupon)==0){
    return back()->withErrors('No such coupon code found');
    }

    if($coupon->no_of_uses<=0){
    return back()->withErrors('Coupon code is not available now!');
    }

    $discount=round(($coupon->percent_off)*0.01*((float)str_replace(',', '', Cart::subtotal())+(float)str_replace(',', '', Cart::tax())),2);
    session(['coupon_id'=>$coupon->id]);
    session(['percent_off'=>$coupon->percent_off]);
    session(['discount'=>$discount]);
   $cart_total=((float)str_replace(',','',Cart::total()))-session()->get('discount');
   session(['cart_total'=>round($cart_total,2)]);

   Session::flash('success','Discount applied!');
    return back();
 }
/*

Payment checkout view

*/

  public function checkoutView(Request $request){
    $user_addresses=UserAddress::where('user_id',$request->user()->id)->get();
    return view('frontend.checkout',['configurations'=>$this->configuration,'addresses'=>$user_addresses]);
  }

  public function saveCheckoutData(Request $request){
    if($request->delivery_address){
      session(['delivery_address'=>$request->delivery_address]);
    }

    if($request->billing_address){
      session(['billing_address'=>$request->billing_address]);
    }

    if($request->payment){
      $payment=($request->payment=="cod")?1:2;
      session(['payment'=>$payment]);
    }
    return true;
    //return redirect()->route('accounts.order_review');
  }
/*

Order review view

*/
  public function showOrderReview(){

    $delivery_address=UserAddress::findOrFail(session()->get('delivery_address'));
    $billing_address=UserAddress::findOrFail(session()->get('billing_address'));
      
    return view('frontend.order_review',['configurations'=>$this->configuration,'delivery_address'=>$delivery_address,'billing_address'=>$billing_address]);

}
/*
Select payment method.
If COD => create orders
If paypal=>redirect to Paypal 

*/
  
  public function decidePayment(Request $request){

  if(session()->get('payment')==2)
    return redirect()->route('payment.paypal');
  
  return redirect()->route('accounts.save_order');

  }

/*

Create order and clear Cart and other session variables.

*/
  public function saveOrder(Request $request){

    $user_order= UserOrder::create(['user_id'=>$request->user()->id,
                                      'billing_address_id'=>(int)session()->get('billing_address'),
                                      'shipping_address_id'=>(int)session()->get('delivery_address'),
                                      'AWB_NO'=>'abcd45',
                                      'payment_gateway_id'=>session()->get('payment')
                                      ,'transaction_id'=>null,
                                      'status'=>'pending',
                                      'grand_total'=>session()->get('cart_total'),
                                      'shipping_charges'=>0.00,
                                      'coupon_id'=>session()->get('coupon_id')]
                                      );

      
     
      $success=$user_order->save();

       if($success){
        $total_items=Cart::content();
      foreach($total_items as $item){
       
        $order_detail=OrderDetail::create(['order_id'=>$user_order->id,'product_id'=>$item->id,'quantity'=>$item->qty,'amount'=>($item->price*$item->qty)]);
        $order_success=$order_detail->save();
        $product=Product::findOrFail($item->id);
        $product->quantity=$product->quantity-$item->qty;
        $product->save();
      }
    }
    if(session()->has('coupon_id')){
     $coupon=Coupon::findOrFail(session()->get('coupon_id'));
    $coupon->no_of_uses=-1;
  }
   
    Cart::destroy();
    session()->forget('coupon_id');
    session()->forget('discount');
    session()->forget('payment');
    session()->forget('cart_total');
    session()->forget('percent_off');

    Session::flash('success','Order Placed!!');
    return redirect()->route('home');
}
/*

List all orders and their status

*/
  public function viewOrders(){

    $orders=UserOrder::with('get_order_details.get_product_details.get_images')->where('status','<>','cancelled')->get();

    return view('frontend.view_orders',['configurations'=>$this->configuration,'orders'=>$orders]);
  }
    
/*

Cancel order
*/
  public function cancelOrder(Request $request,$id){
   $order =UserOrder::destroy($id);
   Session::flash('success','Order Cancelled!!');
   return redirect()->route('home');
   
  }



}
