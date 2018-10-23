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
use Cart;
use Sessions;
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
        $this->categories='App\Category'::where('parent_id','<>',null)->where('status','1')->get();
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


        return redirect()->route('accounts.details',$request->user()->id);

    }

    public function addItemToCart(Request $request,$id){
     

      $product=Product::with('get_images')->findOrFail($id);

      if($request->quantity==null || $request->quantity==0){
      return back()->withInput($request->input())->withErrors('Min unit needs to be 1');
    }
      if($request->quantity>$product->quantity ){
        return back()->withInput($request->input())->withErrors('Only '.$product->quantity.'units are available');
      }

      Cart::add(['id'=>$product->id,'name'=>$product->name,'qty'=>$request->quantity,'price'=>$product->price,'options'=>['image'=>$product->get_images->first()->image_name]]);

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
      return $item;
    }

    echo false;
      
  }


  public function deleteCart(Request $request){
    Cart::remove($request->rowId);

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

    if(session()->has('discount')){
    return back()->withErrors("Only one discount is applicable on one order");
  }
    $discount=($coupon->percent_off)*0.01*(Cart::subtotal());
   session(['discount'=>$discount]);
   return back();
  }
    
}
