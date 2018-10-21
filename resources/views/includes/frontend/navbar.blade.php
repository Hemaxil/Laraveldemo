<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
							@if(count($configurations)>0)
								@foreach($configurations as $conf_key=>$conf_value)
									<li><a href="#"><i class="fa fa-phone"></i> 
										{{$conf_key}}:{{$conf_value}}
									</a></li>
								@endforeach
							@endif
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
		
	