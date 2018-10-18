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
      <h3 class="box-title">User Create</h3>
    </div>
            <!-- /.box-header -->
            <!-- form start -->

    {!! Form::open(['route' => 'users.store','class'=>'form-horizontal']) !!}
      <div class="box-body">
        <div class="form-group">
          {{Form::label('firstname', 'First Name',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::text ('firstname','',['class'=>'form-control'])}}
          </div>
        </div>

        <div class="form-group">
          {{Form::label('lastname', 'Last Name',['class'=>'col-sm-2  control-label'])}}
          <div class="col-sm-4">
            {{Form::text ('lastname','',['class'=>'form-control'])}}
          </div>
        </div>

        <div class="form-group">
          {{Form::label('email', 'Email Id',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::email ('email','',['class'=>'form-control'])}}
          </div>
        </div>

        <div class="form-group">
          {{Form::label('password','Password',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::password ('password',['class'=>'form-control'])}}
          </div>
        </div>

        <div class="form-group">
          {{Form::label('password_confirmation', 'Confirm Password',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::password ('password_confirmation',['class'=>'form-control'])}}
          </div>
        </div>



        <div class="form-group">
          {{Form::label('status', 'Status',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-4">
            {{Form::select('status', ['0' => 'Disabled', '1' => 'Enabled'], '1',['class'=>'custom-select '])}}
          </div>
   
        </div>

        <div class="form-group">
          {{Form::label('roles', 'Role',['class'=>'col-sm-2 control-label'])}}
          
          	<div class="col-sm-4">
	            @foreach($roles as $role)
	            <div>
	              <label>{{Form::checkbox('roles[]', $role->id) }}{{$role->name}} </label>
	            </div>
	            @endforeach
	        </div>
          
        	
      </div>
      <div class="box-footer">
          {!! Form::submit($value='Create',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}


@endsection
@section('additional_js')

<script type="text/javascript">
  $(".breadcrumb").append('<li class="active"><a href="{{route('users.index')}}">Users</a></li>');
</script>
  
@endsection