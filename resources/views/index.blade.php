@extends('layouts.frontend_master')
@section('headerbottom')
	@include('includes.frontend.headerbottom')
@endsection

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
@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
		{{Session::get('success')}}
		</div>
		
@endif
	@if(isset($banners))
		<section id="slider"><!--slider-->
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div id="slider-carousel" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
								@for($i=1;$i<count($banners);$i++)
									<li data-target="#slider-carousel" data-slide-to="{{$i}}"></li>
								@endfor
								
								
							</ol>
							
							<div class="carousel-inner">
								@foreach($banners as $banner)
									@if($loop->first)
										<div class="item active">
									@else
										<div class="item">
									@endif
										<div class="col-sm-6">
											<h1><span>E</span>-SHOPPER</h1>
											<h2>
												@if($banner->title)
													{{$banner->title}}
												@endif</h2>
											<p>
												@if($banner->content)
													{{$banner->content}}
												@endif </p>
											<button type="button" class="btn btn-default get">Get it now</button>
										</div>
										<div class="col-sm-6">
											<img src='{{asset('storage/banners/'.$banner->image)}}' class="girl img-responsive" alt="" />
											
										</div>
									</div>

								@endforeach
								
							</div>	
								
							
							<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							</a>
							<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						
					</div>
				</div>
			</div>
		</section><!--/slider-->
	@endif
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					{{-- @include('includes.frontend.sidebar') --}}
					<div class="shipping text-center"><!--shipping-->
						<img src={{asset("eshopper/images/home/shipping.jpg")}} alt="" />
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						@if(count($featured_items)>0)
							@foreach($featured_items as $item)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
													<div class="productinfo text-center">
														@if(count($item->get_images)>0)
														@foreach($item->get_images as $image)
																@if($loop->first)
																	<img src={{asset('storage/products/medium/'.$image->image_name)}} alt="" />
																@endif
														@endforeach
														@endif
														@if($item->special_price_from && $item->special_price_to)
			
															@if(date('Y-m-d')<=$item->special_price_to && date('Y-m-d')>=$item->special_price_from)
																	<h2><i class='fa fa-inr'></i>{{$item->special_price}}</h2>
																	@else 
																	<h2><i class='fa fa-inr'></i>{{$item->price}}</h2>

															@endif
														@else
															<h2><i class='fa fa-inr'></i>{{$item->price}}</h2>


														@endif
				

		
														
														<p>{{$item->name}}</p>
														@if($item->quantity<=0)
															<a class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><s>Add to cart</s></a>
														@else
															{{Form::open(['route'=>['accounts.addToCart',$item->id],'id'=>'addtocart'])}}
											
															<input type="text" id="quantity" name="quantity" value=1 hidden/>
															<input type="submit" class="btn btn-default cart hidden"><a href="#" class="addtocart_button btn btn-default cart"><i class="fa fa-shopping-cart "></i>
															Add to cart</a>
														{{Form::close()}}
														@endif

													</div>
													<div class="product-overlay">
														<div class="overlay-content">
														@if($item->special_price_from && $item->special_price_to)
			
															@if(date('Y-m-d')<=$item->special_price_to && date('Y-m-d')>=$item->special_price_from)
																	<h2><i class='fa fa-inr'></i>{{$item->special_price}}</h2>

															@else
																<h2><i class='fa fa-inr'></i>{{$item->price}}</h2>
															@endif
														@else
															<h2><i class='fa fa-inr'></i>{{$item->price}}</h2>


														@endif
															<p>{{$item->name}}</p>
															@if($item->quantity<=0)
																<a class="btn btn-default add-to-cart disabled"><i class="fa fa-shopping-cart"></i><s>Add to cart</s></a>
															@else
																{{Form::open(['route'=>['accounts.addToCart',$item->id],'id'=>'addtocart'])}}
											
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
													{{-- <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li> --}}
													<li><a href="{{route('get_product_details',$item->id)}}"><i class="fa fa-plus-square"></i>View Details</a></li>
												</ul>
											</div>
										</div>
									</div>
								
								
							@endforeach
						@else
						<p> No Featured Products Found !!!</p>
						@endif
						
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
	