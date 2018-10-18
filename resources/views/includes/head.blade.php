<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    @if(!empty($title))
      {{$title}}
    @else
      AdminLTE
    @endif
   </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  {{-- <link rel="stylesheet" href={{asset("bower_components/select2/dist/css/select2.css")}}> --}}
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href={{asset("bower_components/bootstrap/dist/css/bootstrap.min.css")}}>
  <!-- Font Awesome -->
  <link rel="stylesheet" href={{asset("bower_components/font-awesome/css/font-awesome.min.css")}}>
{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">  --}}

<!-- bootstrap datepicker -->
  <link rel="stylesheet" href={{{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}>
 <link rel="stylesheet" href={{asset("bower_components/select2/dist/css/select2.css")}}>
<link rel="stylesheet" href={{asset("css/bootstrap-multiselect.css")}} type="text/css" >


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

