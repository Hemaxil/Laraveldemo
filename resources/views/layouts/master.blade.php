@include('includes.head',['title'=>'DemoCart'])

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