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
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						{!! Form::open(['route' => 'login','id'=>'user_login_form']) !!}
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email"  autofocus>
							<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" >
							<span>
								<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
							</span>
							 <button type="submit" class="btn btn-default">Sign In</button>
						{{Form::close()}}
						<div class="social-auth-links text-center">
        					<p>- OR -</p>
        					<a href="{{route('user.facebook')}}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>

					        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
	      				</div>
	      				<a href="{{ route('password.request') }}">{{ __(' I forgot my password ') }}</a>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						{!! Form::open(['route' => 'register','id'=>'user_register_form']) !!}
							<input  type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required autofocus>

							<input  type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required autofocus>

							<input id="register_email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

							<input id="register_password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>

							<button type="submit" class="btn btn-default">Signup</button>
						{{Form::close()}}
							<div class="social-auth-links text-center">
	        					<p>- OR -</p>
	        					<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>

						        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
	      					</div>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection

@section('additional_js')
<script type="text/javascript" src="{{asset('js/userlogin.js')}}"></script>
@endsection
	
	