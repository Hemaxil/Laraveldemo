<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								
								@foreach($configurations as $conf_key=>$conf_value)
									<li><a href="#"><i class="fa fa-phone"></i> 
										{{$conf_key}}:{{$conf_value}}
									</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					{{-- <div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div> --}}
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{route('guest_home')}}"><img src={{asset("eshopper/images/home/logo.png")}} alt="" /></a>
						</div>
						
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
								<li><a href=@auth {{route('home')}} @endauth @guest {{route('user.login')}} @endguest><i class="fa fa-star"></i> Wishlist</a></li>
								<li><a href=@auth {{route('home')}} @endauth @guest {{route('user.login')}} @endguest><i class="fa fa-crosshairs"></i> Checkout</a></li>
								<li><a href=@auth {{route('home')}} @endauth @guest {{route('user.login')}} @endguest><i class="fa fa-shopping-cart"></i> Cart</a></li>
								@guest
									<li><a href="{{route('user.login')}}"><i class="fa fa-lock"></i> Login</a></li>
								@endguest
								@auth
									<li><a href="{{ route('logout') }}"
	                                       onclick="event.preventDefault();
	                                                     document.getElementById('logout-form').submit();">
	                                        {{ __('Logout') }}
	                                <i class="fa fa-lock"></i></a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
									
								@endauth
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html" class="active">Home</a></li>
								@foreach($categories as $category)
								<li class="dropdown"><a href="#" class='category_parent_{{$category->id}}'>{{$category->name}}<i class="fa fa-angle-down"></i></a>
									<!-- @if($category->child_category())
	                                    <ul role="menu" class="sub-menu">
	                                    	@foreach($category->child_category as $child_category)
		                                        <li><a href="shop.html">{{$child_category->name}}</a></li>

		                                        <li><a href="shop.html">Products</a></li>
												<li><a href="product-details.html">Product Details</a></li> 
												<li><a href="checkout.html">Checkout</a></li> 
												<li><a href="cart.html">Cart</a></li> 
												<li><a href="login.html">Login</a></li>
											@endforeach
	                                    </ul>
	                                @endif -->
                                </li>
                                @endforeach
								<li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li> 
								<li><a href="404.html">404</a></li>
								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->