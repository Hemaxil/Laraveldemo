@extends('layouts.auth_master',['title'=>'Login'])

@section('content')
  
          <form method="POST" action="{{ route('login') }}" id="user_login_form">
              @csrf
              <div class="form-group has-feedback">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                      @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                      @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="checkbox icheck">
                      <label>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                  </div>
                  <!-- /.col -->
                </div>
              
          </form>
     
               

@endsection
@section('additional_js')
<script type="text/javascript" src="{{asset('js/admin_user.js')}}"></script>
@endsection
