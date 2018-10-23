@extends('layouts.frontend_master')

@section('content')
<section>
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
	<div class="container">
			<div class="row">
				<div class="col-sm-3">
					@include('includes.frontend.sidebar')
					<div class="shipping text-center"><!--shipping-->
						<img src={{asset("eshopper/images/home/shipping.jpg")}} alt="" />
					</div>
				</div>
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								@if(count($product->get_images)>0)
									<img id="product-image" src={{asset('storage/products/medium/'.$product->get_images->first()->image_name)}}>
								@endif
<!-- 								<h3>ZOOM</h3>
 -->						</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    
										
								<div class="item">
									@if(count($product->get_images)>0)
									<span>
										@foreach($product->get_images as $image)
										<img class="product_image" src={{asset('storage/products/small/'.$image->image_name)}} width="70px" height="70px">
										@endforeach
									</span>
									@endif
								</div>
										
									
							</div>


							<div>
								@if(count($product->get_attributes)>0)
									@foreach($product->get_attributes as $attribute)
									@endforeach
								@endif
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								{{-- <img src="images/product-details/new.jpg" class="newarrival" alt="" /> --}}
								<h2>{{$product->name}}</h2>
								<p>SKU: {{$product->sku}} </p>
								{{-- <img src="images/product-details/rating.png" alt="" /> --}}
								<p>
									@if($original_price!=0)
									<p class="cart" style="display:inline;">Special Offer!!</p>
									<p class="strikethrough"><i class="fa fa-inr">{{$original_price}}</i></p>
									@endif
								
								</p>
								<span>
									
									<span><i class="fa fa-inr"></i>
										{{$product->price ?:0}}</span>
									@if($product->quantity>0)
										@auth
										{{Form::open(['route'=>['accounts.addToCart',$product->id],'id'=>'addtocart'])}}
										<span>
											<label style="font-size:0.5em;">Quantity:</label>
											<input type="text" id="quantity" name="quantity"/>
											<input type="submit" class="btn btn-default cart hidden"><a href="#" class="addtocart_button btn btn-default cart"><i class="fa fa-shopping-cart "></i>
												Add to cart</a>
										</span>
										{{Form::close()}}
												
										@endauth
									@endif
								</span>
								<p><b>Availability:</b> @if($product->quantity<=0) Out Of Stock @else In Stock @endif</p>
								
								<!-- sharing on social media -->
							</div>
							<div>
								<p>{{$product->long_description}}</p>
								<div>
									Attributes
									@if(count($product->get_attributes)>0)
										@foreach($product_attributes as $attributes)
											<p>{{$attributes->get_attribute_name->name}}:-{{$attributes->get_attribute_value_name->attribute_value}}</p>
										@endforeach
									@endif


								</div>
						</div>
							<!--/product-information-->
						</div>
					</div><!--/product-details-->
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

	$(".addtocart_button").click(function(event){
		event.preventDefault();
		$("#addtocart").submit();

	})
</script>
 
@endsection
	