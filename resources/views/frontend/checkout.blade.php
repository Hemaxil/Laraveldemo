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
@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
		{{Session::get('success')}}
		</div>
		
@endif
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Check out</li>
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
					@if(count($addresses)>0)
						@foreach($addresses as $address)

						<div>
							@if($loop->first)
								<input type="radio" name="delivery_address[]" id="delivery_{{$address->id}}" checked>
							@else
								<input type="radio" name="delivery_address[]" id="delivery_{{$address->id}}">
							@endif
								<p>{{$address->address1}}</p>
								<p>{{$address->address2}}</p>
								<p>{{$address->city}},{{$address->state}}</p>
								<p>{{$address->country}}-{{$address->zipcode}}</p>

						</div>
						
						@endforeach
					@endif	
					</div>
					
					<div class="col-sm-6 clearfix">
						<div class="bill-to">
							<p>Add New Address</p>
						</div>	
						<div class="form-one" >

							{{Form::open(['route' => ['accounts.store_address',auth()->user()->id],'id'=>'user_address_form'])}}
								
								{{Form::text('address1','',['placeholder'=>'Address 1'])}}
							
								{{Form::text('address2','',['placeholder'=>'Address 2'])}}
							
								{{Form::text('city','',['placeholder'=>'City'])}}
							
								{{Form::text('state','',['placeholder'=>'State'])}}
							
								{{Form::text('country','',['placeholder'=>'Country'])}}
							
								{{Form::number('zipcode','',['placeholder'=>'ZipCode'])}}
							
								{{Form::submit('Add Address',['class'=>'btn btn-primary'])}}
							
							{{Form::close()}}
						</div>
					</div>
				</div>
				<div>
					<span><input type="checkbox" name="same_as_billing" id="same_as_billing">Make billing address same as delivery address</span>
				</div>

				<div class="row billing_address">
					
					<div class="register-req">
						<p>Billing Address</p>
					</div>
					<div class="col-sm-6">
						@if(count($addresses)>0)
							@foreach($addresses as $address)
							<div>
								@if($loop->first)
									<input type="radio" name="billing_address[]" id="billing_{{$address->id}}" checked>
								@else
									<input type="radio" name="billing_address[]" id="billing_{{$address->id}}">
								@endif
									
									<p>{{$address->address1}}</p>
									<p>{{$address->address2}}</p>
									<p>{{$address->city}},{{$address->state}}</p>
									<p>{{$address->country}}-{{$address->zipcode}}</p>

							</div>
							
							@endforeach
						@endif	
					</div>
					
					<div class="col-sm-6 clearfix">
						<div class="bill-to">
							<p>Add New Address</p>
						</div>	
						<div class="form-one">

							{{Form::open(['route' => ['accounts.store_address',auth()->user()->id],'id'=>'user_address_form'])}}
								
								{{Form::text('address1','',['placeholder'=>'Address 1'])}}
							
								{{Form::text('address2','',['placeholder'=>'Address 2'])}}
							
								{{Form::text('city','',['placeholder'=>'City'])}}
							
								{{Form::text('state','',['placeholder'=>'State'])}}
							
								{{Form::text('country','',['placeholder'=>'Country'])}}
							
								{{Form::number('zipcode','',['placeholder'=>'ZipCode'])}}
							
								{{Form::submit('Add Address',['class'=>'btn btn-primary'])}}
							
							{{Form::close()}}
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
							<td colspan="3">&nbsp;</td>
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
				
					<span>
						<label><input type="radio" name="payment" id="cod" checked> COD</label>
					</span>
					<span>
						<label><input type="radio" name="payment" id="paypal"> Paypal</label>
					</span>

			</div>
			{{Form::open(['route'=>'accounts.order_review','id'=>'order_review','method'=>'GET'])}}
				<input type="submit" value="Place Order" class="continue btn btn-default cart ">
			{{Form::close()}}
		</div>

			
		
	</section> <!--/#cart_items-->
@endsection
@section('additional_js')
<script type="text/javascript" src={{asset("js/user_address.js")}}></script>
<script type="text/javascript">
	
	$("#same_as_billing").change(function(){
		if($(this).prop("checked")){
			$(".billing_address").hide();
		}else{
			$(".billing_address").show();
		}
	});

	$(".continue").click(function(){
		var delivery_address,billing_address,payment;
		delivery=$("input[id*='delivery_']");
		$.each(delivery,function(){
			if($(this).prop("checked")){
				delivery_address=($(this).attr('id')).split('_')[1];
			}
		});
		if($("#same_as_billing").prop("checked")){
			billing_address=delivery_address;
		}else{
			billing=$("input[id*='billing'");
			$.each(billing,function(){
			if($(this).prop("checked")){
				billing_address=($(this).attr('id')).split('_')[1];
				}
			});

		}

		if($("#cod").prop("checked")){
			payment="cod";
		}
		if($("#paypal").prop("checked")){
			payment="paypal";
		}

		$.ajax({
			url:'{{route('accounts.save_checkout')}}',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{'delivery_address':delivery_address,'billing_address':billing_address,'payment':payment},
	        type: "post",
		}).done(function (result){
			if(result){
				$("#order_review").submit();
			}
		});	
	})


</script>
@endsection