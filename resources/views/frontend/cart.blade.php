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
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				@if(count($cart_items)<=0)
				<div class="text-center" style="margin:20px;">
							NO Items in Cart
							<a class="btn btn-default cart" href={{route('home')}}>Continue Shopping</a>
						</div>
				@else
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>

						@foreach($cart_items as $item)
					
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
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value={{$item->qty}} autocomplete="off" size="2" readonly min=1>
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{$item->subtotal}}</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
								{{Form::open(['route'=>['accounts.delete'],'id'=>'cart_delete','method'=>'Delete'])}}
									<input type="hidden" value={{$item->rowId}} name="rowId">
									<input type="submit" hidden> 

								{{Form::close()}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@endif
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>What would you like to do next?</h3>
				<p>Enter COUPON code if you have one.</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
								
						{{Form::open(['route'=>'accounts.get_discount','method'=>'POST','id'=>'coupon_apply'])}}
						<label>Coupon Code</label>
						<input type="text" name="coupon">
						<input type="submit" hidden>
						<a class="apply_coupon btn btn-default cart" href="">Get Discount</a>
						{{Form::close()}}
						
							
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li id="product_total">Cart Sub Total <span>{{(float)str_replace(',', '', Cart::subtotal())}}</span></li>
							<li id="tax">Tax <span>{{(float)str_replace(',', '', Cart::tax())}}</span></li>
							<li id="shipping_cost">Shipping Cost <span>Free</span></li>
							<li id="coupon_discount">Coupons Discount<span>{{session()->has('discount')&&Cart::count()>0 ?session()->get('discount'):0}}</span>
							<li id="cart_total">Total <span>@if(session()->has('discount')&&Cart::count()>0)
									{{(float)str_replace(',', '', Cart::total())-session()->get('discount')}}

								@else
									{{(float)str_replace(',', '', Cart::total())}}
									
								@endif</span></li>
						</ul>
							<a class="btn btn-default update" href="">Update</a>
							<a class="btn btn-default check_out {{(Cart::count()<=0)?'disabled':''}}" href="{{route('accounts.get_checkout')}}">Check Out</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->

	

@endsection

@section('additional_js')
<script type="text/javascript">
$(document).ready(function(){
	$(".cart_quantity_up").click(function(event){
		event.preventDefault();
		$value=parseInt($(this).parent().children(".cart_quantity_input").val())+1;
		$(this).parent().children(".cart_quantity_input").attr('value',$value);
		$productId=$(this).parent().attr('id');
		$rowId=$(this).parent().parent().parent('tr').attr('id');

		$.ajax({
				url:'{{route("accounts.update_cart")}}',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{'rowId':$rowId,'qty':$value,'productId':$productId},
	        	type: "post",
	        	dataType:'json',
			}).done(function(result){
				
				$rowobject=$("#"+result[0].rowId+" .cart_quantity .cart_quantity_input");
				if(result[0].qty<$rowobject.val()){
					alert("Exceeded limit!!");
					$rowobject.attr('value',result[0].qty);
				}
				$("#"+result[0].rowId+" .cart_total_price").html(result[2]);
				console.log(result[0].subtotal)
				$("#product_total span").html(result[2]);
				$("#tax span").html((result[3]));
				$("#coupon_discount span").html(result[1]);
					$("#cart_total span").html(result[4]);

			
				
			});
		
	});
	$(".cart_quantity_down").click(function(event){

		event.preventDefault();
		$value=parseInt($(this).parent().children(".cart_quantity_input").val())-1;
		if($value>0){
			$(this).parent().children(".cart_quantity_input").attr('value',$value);
		$productId=$(this).parent().attr('id');
		$rowId=$(this).parent().parent().parent('tr').attr('id');
		$.ajax({
				url:'{{route("accounts.update_cart")}}',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{'rowId':$rowId,'qty':$value,'productId':$productId},
            	type: "post",
            	dataType:'json',
			}).done(function(result){
				console.log(result[0].rowId);

				$("#"+result[0].rowId+" .cart_total_price").html(result[2]);
				
				$("#product_total span").html(result[2]);
				$("#tax span").html((result[3]));
				$("#coupon_discount span").html(result[1]);
					$("#cart_total span").html(result[4]);
		
			});
			
			}
		

	});

	$(".cart_quantity_delete").click(function(event){
		event.preventDefault();
		$(this).parent().children("#cart_delete").submit();
	});

	$(".apply_coupon").click(function (event){
		event.preventDefault();
		$(this).parent("#coupon_apply").submit();
	})
	
});
//$("#cart_total span").html(parseInt($("#product_total span").html())+parseInt($("#tax span").html()));

	
</script>

	
@endsection

{{-- // $.each($(this),function(){
		// 	console.log($(this).parent('tr'));
		// 	$.ajax({
		// 		url:'{{route("accounts.update_cart")}}',
		// 		headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
		// 		data:{'rowId':data},
  //           	type: "post",
		// 	});
		// }) --}}