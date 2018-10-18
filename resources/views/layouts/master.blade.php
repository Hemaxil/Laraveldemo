<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Demo Cart</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset("bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href={{asset("bower_components/font-awesome/css/font-awesome.min.css")}}>
  <!-- Ionicons -->
  <link rel="stylesheet" href={{asset("bower_components/Ionicons/css/ionicons.min.css")}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{asset("dist/css/AdminLTE.min.css")}}>
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href={{asset("dist/css/skins/skin-blue.min.css")}}>

 <link rel="stylesheet" href={{asset("bower_components/select2/dist/css/select2.css")}}>
<link rel="stylesheet" href={{asset("css/bootstrap-multiselect.css")}} type="text/css" >
  {{-- <link rel="stylesheet" href={{asset("css/app.css")}}> --}}
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>DC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Demo Cart</b></span>
    </a>
  @include('includes.navbar')
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  @include('includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @isset($page_header)
          {{$page_header}}
        @endif
        <small>
        @isset($page_desc)
          {{$page_desc}}
        @endif</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      
          @yield('content')

    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('includes.footer')

</body>
</html>