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




    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
      public function index(Request $request){

        $products=Product::with('get_images')->where(['future'=>'1','status'=>'1'])->get();
       
        
        return view('index',['banners'=>$this->banners,'configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'featured_items'=>$products]);
    }


      public function showAccountsPage(Request $request){

        $user_address=UserAddress::where('user_id',$request->user()->id)->get();

        return view('frontend.account_details',['configurations'=>$this->configuration,'user_address'=>$user_address]);

    }

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

    public function addItemToCart(Request $request,$id){
     

      $product=Product::with('get_images')->findOrFail($id);

      if($request->quantity==null || $request->quantity==0){
      return back()->withInput($request->input())->withErrors('Min unit needs to be 1');
    }
      if($request->quantity>$product->quantity ){
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


    public function showCart(Request $request){

      $cart_items=Cart::content();
      return view('frontend.cart',['configurations'=>$this->configuration,'cart_items'=>$cart_items]);

    }


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


  public function deleteCart(Request $request){
    Cart::remove($request->rowId);
    if(Cart::count()==0){
      session(['discount'=>0]);
    }
    Session::flash('success','Item delted!');
    return redirect()->route('accounts.get_cart');

  }


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

  public function showOrderReview(){

    $delivery_address=UserAddress::findOrFail(session()->get('delivery_address'));
    $billing_address=UserAddress::findOrFail(session()->get('billing_address'));
      
    return view('frontend.order_review',['configurations'=>$this->configuration,'delivery_address'=>$delivery_address,'billing_address'=>$billing_address]);

}
  
  public function decidePayment(Request $request){

  if(session()->get('payment')==2)
    return redirect()->route('payment.paypal');
  
  return redirect()->route('accounts.save_order');

  }
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

  public function viewOrders(){

    $orders=UserOrder::with('get_order_details.get_product_details.get_images')->where('status','<>','cancelled')->get();

    return view('frontend.view_orders',['configurations'=>$this->configuration,'orders'=>$orders]);
  }
    

  public function cancelOrder(Request $request,$id){
   $order =UserOrder::destroy($id);
   Session::flash('success','Order Cancelled!!');
   return redirect()->route('home');
   
  }



}
