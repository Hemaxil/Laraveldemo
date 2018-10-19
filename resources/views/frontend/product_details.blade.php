@extends('layouts.frontend_master')

@section('content')
<section>
	<div class="container">
			<div class="row">
				<div class="col-sm-3">
					@include('includes.frontend.sidebar')
					<div class="shipping text-center"><!--shipping-->
						<img src={{asset("eshopper/images/home/shipping.jpg")}} alt="" />
					</div>
				</div>
				
				<div class="col-sm-9" style="padding-top: 100px;">
					<div class='row panel panel-default' >
						<div class="col-sm-6 panel-body">
							@if(count($product->get_images)>0)
							<img id="product-image" src={{asset('storage/products/medium/'.$product->get_images->first()->image_name)}}>
							@endif
						</div>
						<div class="col-sm-6 panel-body">
							<h4>{{$product->name}}</h4>
							<p>{{$product->sku}}</p>
							<div>
								{{$product->price}}
							</div>
							@if($product->quantity<=0)
								<p>Out of Stock</p>
							@else
							<input type=number id=quantity name=quantity>
							@endif

							<div>
								if(count($product->get_attributes)>0)
							</div>
						</div>
					</div>
					<div class='row'>
						@if(count($product->get_images)>0)
							@foreach($product->get_images as $image)
							<img class="product_image" src={{asset('storage/products/small/'.$image->image_name)}}>
							@endforeach
						@endif
					</div>
						
						
				</div>
				
				
			</div>

	</div>
</section>
				
				

@endsection
@section('additional_js')
<script type="text/javascript">
	$(".product_image").hover(function(){
		$url=($(this).attr('src')).split('/');
		$image_name=$url.slice(-1)[0];
		$("#product-image").attr('src','/storage/products/medium/'+$image_name);


	})
</script>
 
@endsection
	