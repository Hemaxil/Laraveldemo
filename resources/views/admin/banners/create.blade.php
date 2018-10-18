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
      <h3 class="box-title">Banners Create</h3>
    </div>
            <!-- /.box-header -->
            <!-- form start -->

    {!! Form::open(['route' => 'banners.store','class'=>'form-horizontal','enctype'=>"multipart/form-data"]) !!}
      <div class="box-body">
        <div class="form-group">
          {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::text ('title','',['class'=>' form-control'])}}
          </div>
        </div>
      <div class="form-group">
        {{Form::label('content', 'Content',['class'=>'col-sm-2 control-label'])}}
        <div class="col-sm-4">
          {{Form::textarea ('content','',['class'=>' form-control','rows'=>'4'])}}
        </div>
      </div>
      <div class="form-group">
        {{Form::label('image', 'Image Upload',['class'=>'col-sm-2 control-label'])}}
        <div class="col-sm-4">
          {{Form::file ('image')}}
          <p class="help-block">Please enter image files only</p>
        </div>
      </div>
      <div class="form-group">
          {{Form::label('status', 'Status',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::select('status', ['0' => 'Disabled', '1' => 'Enabled'], '1',['class'=>'form-control '])}}
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