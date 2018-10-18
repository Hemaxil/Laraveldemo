@extends('layouts.master')
@section('content')
	<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Configuration Create</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'roles.store','class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                  {{Form::label('name', 'Role Name',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-10">
                  	{{Form::text ('name','',['class'=>'form-control'])}}
                  </div>
                </div>

            </div>
            <div class="box-footer">
              	{!! Form::submit($value='Create',['class'=>'btn btn-primary']) !!}
            </div>
              <!-- /.box-footer -->
            {!! Form::close() !!}
    </div>
@endsection
@section('additional_js')

<script type="text/javascript">

  $(".breadcrumb").append('<li class="active"><a href="{{route('roles.index')}}">Roles</a></li>');
</script>
  
@endsection
