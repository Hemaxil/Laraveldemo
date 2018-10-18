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
      <h3 class="box-title">Categories Create</h3>
    </div>
            <!-- /.box-header -->
            <!-- form start -->
    {!! Form::open(['route' => 'categories.store','class'=>'form-horizontal']) !!}
   
      <div class="box-body">

        <div class="form-group">
          {{Form::label('name', 'Category Name',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::text ('name','',['class'=>'form-control'])}}
          </div>
        </div>

        <div class="form-group">
          {{Form::label('parent', 'Parent Category',['class'=>'col-sm-2 control-label'])}}
          <div class="col-md-4">
            {{Form::select('parent',$parent_category,'0',['class'=>'form-control'])}}
          </div>
        </div>
       
    	<div class="form-group">
          {{Form::label('status', 'Status',['class'=>'col-sm-2 control-label'])}}
          <div class="col-md-4">
            {{Form::select('status', ['0' => 'Disabled', '1' => 'Enabled'], '1',['class'=>'form-control '])}}
          </div>

        </div>
   
      </div>

      <div class="box-footer">
          {!! Form::submit($value='Create',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}


@endsection
@section('additional_js')

<script type="text/javascript">
  $(".breadcrumb").append('<li class="active"><a href="{{route('categories.index')}}">Categories</a></li>');
</script>
  
@endsection