@extends('layouts.frontend_master')
@section('content')


@if (count($errors) > 0)
	<div class="alert alert-danger">
{{-- 	<strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
	<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
	</ul>
	</div>
@endif
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Order Review</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="step-one">
				<h2 class="heading">User Details</h2>
			</div>
			<div class="checkout-options">
				
				<p>{{auth()->user()->firstname}}</p>
				<p>{{auth()->user()->email}}</p>
				
			</div><!--/checkout-options-->

			<div class="register-req">
				<p>Delivery Address</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row delivery_address">
					
					<div class="col-sm-6" >
						<div>
							<p>{{$delivery_address->address1}}</p>
							<p>{{$delivery_address->address2}}</p>
							<p>{{$delivery_address->city}},{{$delivery_address->state}}</p>
							<p>{{$delivery_address->country}}-{{$delivery_address->zipcode}}</p>

						</div>
					</div>
				</div>
				<div class="row billing_address">
					
					<div class="register-req">
						<p>Billing Address</p>
					</div>
					<div class="col-sm-6">
			
							<div>
								
									
								<p>{{$billing_address->address1}}</p>
								<p>{{$billing_address->address2}}</p>
								<p>{{$billing_address->city}},{{$billing_address->state}}</p>
								<p>{{$billing_address->country}}-{{$billing_address->zipcode}}</p>

							</div>
							
						
					</div>
				</div>	
			</div>


			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info row">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description">Name</td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						
						@foreach(Cart::content() as $item)
					
						<tr id="{{$item->rowId}}">
							<td class="cart_product">
								@if($item->options->image)
									<a href=""><img src={{asset('storage/products/small/'.$item->options->image)}} width="70px" height="70px" alt=""></a>
								@endif
							</td>
							<td class="cart_description">
								<h4><a href="">{{$item->name}}</a></h4>
							</td>
							<td class="cart_price">
								<p></i>{{$item->price}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button" id={{$item->id}}>
									
									<input class="cart_quantity_input" type="text" name="quantity" value={{$item->qty}} autocomplete="off" size="2" readonly min=1>
									
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{$item->subtotal}}</p>
							</td>
							<td class="cart_delete">
								{{-- <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
								{{Form::open(['route'=>['accounts.delete'],'id'=>'cart_delete','method'=>'Delete'])}}
									<input type="hidden" value={{$item->rowId}} name="rowId">
									<input type="submit" hidden> 

								{{Form::close()}} --}}
							</td>
						</tr>
						@endforeach

						
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td><i class="fa fa-inr"></i>{{Cart::subtotal()}}</td>
									</tr>
									<tr>
										<td> Tax</td>
										<td><i class="fa fa-inr"></i>{{Cart::tax()}}</td>
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>										
									</tr>
									<tr class="Coupon-cost">
										<td>Coupon Discount</td>
										<td><i class="fa fa-inr"></i>{{session()->has('discount')?session()->get('discount'):0}}</td>										
									</tr>
									<tr>
										<td>Total</td>
										<td><span><i class="fa fa-inr"></i>{{session()->has('cart_total')?session()->get('cart_total'):Cart::total()}}</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="payment-options">
				<h3 style="font-family: 'Roboto', sans-serif; color:#696763;font-size:20px;font-weight: 300;">Payment</h3>
				
					<p>@if(session()->get('payment')=='1')
							<em>COD</em>
						@else
							<em>PayPal</em>
						@endif</p>

			</div>
			{{Form::open(['route'=>'decide_payment'])}}
				<input type="submit" value="Confirm Order" class="continue btn btn-default cart ">
			{{Form::close()}}
		</div>

			
		
	</section> <!--/#cart_items-->
@endsection
