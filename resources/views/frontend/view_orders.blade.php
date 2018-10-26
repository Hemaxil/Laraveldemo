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
<div class="category-tab shop-details-tab"><!--category-tab-->
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab">My Orders</a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="details" >
			<div class="col-sm-offset-1 table-responsive cart_info">
				<table class="table table-bordered">
					
					@if(count($orders)>0)
					<tr>
						<th>Order Id</th>
						<th>Details</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Action</th>	
					</tr>
						@foreach($orders as $order)
						<tr id="{{$order->id}}">
							<td>{{$order->id}}</td>
							<td><ul style="background: none;border-bottom:none;">
								@foreach($order->get_order_details as $products)
								<li class="row">
									<div class="col-sm-6"><p>Product Name:{{$products->get_product_details->name}}</p>
										<p>Quantity:{{$products->quantity}} Amount:{{$products->amount}}</p></div>
									<div class="col-sm-6">
										<p><img src={{asset("storage/products/small/".$products->get_product_details->get_images->first()->image_name)}} height:"70px" width="70px"></p>
									</div>
								</li>
								@endforeach
							</ul></td>
							<td><i class="fa fa-inr"></i>{{$order->grand_total}}</td>
							<td>{{$order->status}}</td>
							<td style="cursor: pointer;"><a href="" class="cancel_{{$order->id}}">Cancel Order</a>
								{{Form::open(['route'=>['accounts.cancel_order',$order->id],'method'=>'Delete','id'=>"cancel_".$order->id])}}
									<input type="submit" hidden>{{Form::close()}}
									</td>
								{{Form::close()}}
						</tr>
						@endforeach
					@else

						<p class="text-center">No Orders Found!!</p>

					@endif
				</table>
				
		  	</div>
		</div>
	</div>
</div>



@endsection
@section('additional_js')
<script type="text/javascript">
	$("a[class*='cancel_']").each(function(event){
		$(this).click(function(event){
		event.preventDefault();
		if(confirm('Do you want to Cancel your order?')){
			$("#"+this.className).submit();
		}
	})
	});
</script>
	
@endsection
