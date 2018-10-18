@extends('layouts.master')
@section('content')
  
  @if (count($errors) > 0)
    <div class="alert alert-danger">
  {{--  <strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    </div>
  @endif

  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Create</h3>
    </div>
            <!-- /.box-header -->
            <!-- form start -->

    {!! Form::open(['route' => 'product_attributes_values.store','class'=>'form-horizontal','enctype'=>"multipart/form-data"]) !!}
      <div class="box-body">
        <div class="form-group">
          {{Form::label('attribute', 'Attribute',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::select ('attribute',$attributes,'',['class'=>'form-control'])}}
          </div>
        </div>

         <div class="form-group">
          {{Form::label('attribute_value', 'Value',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::text ('attribute_value','',['class'=>' form-control'])}}
          </div>
        </div>
     

      <div class="box-footer">
          {!! Form::submit($value='Create',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}


@endsection
@section('additional_js')

<script type="text/javascript">
  $(".breadcrumb").append('<li class="active"><a href="{{route('users.index')}}">Banners</a></li>');
</script>
  
@endsection