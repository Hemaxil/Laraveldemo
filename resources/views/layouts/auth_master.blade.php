<!DOCTYPE html>
<html>

@include('includes.head',[$title=>'Login Page'])
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>
      @if(!empty($title))
        {{$title}}
      @endif
    </b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    {{-- <p class="login-box-msg">Sign in to start your session</p> --}}

    @yield('content')
    @if($title=="Login" || $title=="Register")
      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
          Google+</a>
      </div>
    @endif
    <!-- /.social-auth-links -->
      @if($title=="Login")
        <a href="{{ route('password.request') }}">{{ __(' I forgot my password ') }}</a>
        {{-- <a href="{{ route('register') }}" class="text-center">Register a new membership</a> --}}
      @endif
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
 $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
