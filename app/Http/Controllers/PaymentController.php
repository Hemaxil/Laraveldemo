<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Sessions;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class PaymentController extends Controller
{
   
    public function payPaypal(Request $request){
	   
	  $provider = new ExpressCheckout;

	 $data = [];
	  $data['items']=[];
	  foreach(Cart::content() as $rowId=>$item){
	    $item=[
	          'name' => $item->name,
	          'price' => $item->price,
	          'qty' => $item->qty
	    ];

	    array_push($data['items'],$item);
	  }


	  $data['tax']=((float)str_replace(',', '', Cart::tax()));
	  $data['invoice_id'] = uniqid();
	  $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
	  $data['return_url'] = url('/home/checkout/payment_paypal');
	  $data['cancel_url'] = url('/');

	  $total = ((float)str_replace(',', '', Cart::subtotal()))+((float)str_replace(',', '', Cart::tax()));

	  $data['subtotal'] = ((float)str_replace(',', '', Cart::subtotal()));

	 $data['total']=round($total,2);
	  //give a discount of 10% of the order amount
	  if(session()->has('discount')){
	   $data['shipping_discount'] =session()->get('discount');
	}else{
	  $data['shipping_discount'] = 0;}

	  $response = $provider->setExpressCheckout($data);

	  
	  return redirect($response['paypal_link']);
}


public function paypalSuccess(Request $request){

  $provider = new ExpressCheckout;
  $data = [];
  $data['items']=[];
  foreach(Cart::content() as $rowId=>$item){
    $item=[
          'name' => $item->name,
          'price' => $item->price,
          'qty' => $item->qty
    ];

    array_push($data['items'],$item);
  }


  $data['tax']=((float)str_replace(',', '', Cart::tax()));
  $data['invoice_id'] = uniqid();
  $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
  $data['return_url'] = url('/home');
  $data['cancel_url'] = url('/');

   $total = ((float)str_replace(',', '', Cart::subtotal()))+((float)str_replace(',', '', Cart::tax()));

  $data['subtotal'] = ((float)str_replace(',', '', Cart::subtotal()));

  $data['total']=round($total,2);
  //give a discount of 10% of the order amount
  if(session()->has('discount'))
   $data['shipping_discount'] =session()->get('discount');
  else
    $data['shipping_discount'] = 0;
  
  $token=$request->token;
  $PayerID=$request->PayerID;
  $response = $provider->getExpressCheckoutDetails($token);

  $response = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
  if($response['ACK']=="Success")
  	return redirect()->route('accounts.save_order');

  return redirect()->route('accounts.get_cart')->withErrors('Something went wrong!Please try again!! ');

  
  }
}