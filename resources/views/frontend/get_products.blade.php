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
				
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						{{-- <h2 class="title text-center">Feature Items</h2> --}}
						
						@foreach($category_products as $category_product)
							
								@foreach($category_product->get_products as $product)
									@if($product->status==1)
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
														<div class="productinfo text-center">
															@if(count($product->get_images)>0)
																@foreach($product->get_images as $image)
																		@if($loop->first)
																			<img src={{asset('storage/products/medium/'.$image->image_name)}} alt="" />
																		@endif
																@endforeach
															@else
															No image found
															@endif
															<h2><i class="fa fa-inr"></i>{{$product->price ?:0}}</h2>
															<p>{{$product->name}}</p>
															@if($product->quantity<=0)
																<a class="btn btn-default add-to-cart disabled"><i class="fa fa-shopping-cart"></i><s>Add to cart</s></a>
															@else
															{{Form::open(['route'=>['accounts.addToCart',$product->id],'id'=>'addtocart'])}}
												
																<input type="text" id="quantity" name="quantity" value=1 hidden/>
																<input type="submit" class="btn btn-default cart hidden"><a href="#" class="addtocart_button btn btn-default cart"><i class="fa fa-shopping-cart "></i>
																Add to cart</a>
															{{Form::close()}}
															@endif
															
														</div>
														<div class="product-overlay">
															<div class="overlay-content">
																<h2><i class="fa fa-inr"></i>{{$product->price ?:0}}</h2>
																<p>{{$product->name}}</p>
																@if($product->quantity<=0)
																	<a class="btn btn-default add-to-cart disabled"><i class="fa fa-shopping-cart"></i><s>Add to cart</s></a>
																@else
																	{{Form::open(['route'=>['accounts.addToCart',$product->id],'id'=>'addtocart'])}}
												
																<input type="text" id="quantity" name="quantity" value=1 hidden/>
																<input type="submit" class="btn btn-default cart hidden"><a href="#" class="addtocart_button btn btn-default cart"><i class="fa fa-shopping-cart "></i>
																Add to cart</a>
															{{Form::close()}}
																@endif
															
															</div>
														</div>
												</div>
												<div class="choose">
													<ul class="nav nav-pills nav-justified">
													{{-- 	<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li> --}}
														<li><a href="{{route('get_product_details',$product->id)}}"><i class="fa fa-plus-square"></i>View Details</a></li>
													</ul>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							
						@endforeach
						
						
						
						
					</div><!--features_items-->
					
				
				</div>
			</div>
		</div>
	</section>
	

@endsection
@section('additional_js')
<script type="text/javascript">
	$(".addtocart_button").click(function(event){

		event.preventDefault();
		$(this).parent('#addtocart').submit();
		//$("#addtocart").submit();

	})
</script>
@endsection
	