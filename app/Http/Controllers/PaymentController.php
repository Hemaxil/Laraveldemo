<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Sessions;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class PaymentController extends Controller
{
   /*
    Initiate Payment. Compute total amount and set the necessary fields.
    Then redirect to paypal link with the data

   */
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

/*

Receive payment token and payerid after paypal authenticates user info and gives success.

*/
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
// To do payment and receive status using token,payerid and data.If ACK is success, payment is done, redirect to Create a new order.

  $response = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
  session(['transaction_id'=>$response['PAYMENTINFO_0_TRANSACTIONID']]);
  if($response['ACK']=="Success")
  	return redirect()->route('accounts.save_order');

  return redirect()->route('accounts.get_cart')->withErrors('Something went wrong!Please try again!! ');

  
  }
}
