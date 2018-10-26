@extends('layouts.master')
@section('content')
		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Configuration Create</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
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
            {!! Form::model($configuration,['method'=>'PUT','route' => ['configurations.update',$configuration->id],'class'=>'form-horizontal','id'=>'configuration_form']) !!}
              <div class="box-body">
                <div class="form-group">
                  {{Form::label('conf_key', 'Configuration Key Name',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-4">
                  	{{Form::text ('conf_key',null,['class'=>' form-control'])}}
                  </div>
                </div>


                <div class="form-group">
                  {{Form::label('conf_value', 'Configuration Key Value',['class'=>'col-sm-2 control-label'])}}

                  <div class="col-sm-4">
                   {{Form::text ('conf_value',null,['class'=>'form-control'])}}
                  </div>
                </div>

                <div class="form-group">
                	{{Form::label('status', 'Status',['class'=>'col-sm-2 control-label'])}}
                  <div class=" col-sm-4">
                      
                      {{Form::select('status', ['0' => 'Disabled', '1' => 'Enabled'],null,['class'=>'form-control'])}}
                    
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
              	{!! Form::submit($value='Update',['class'=>'btn btn-primary']) !!}
              </div>
              <!-- /.box-footer -->
            {!! Form::close() !!}
    </div>

	
	
		
@endsection

@section('additional_js')

<script type="text/javascript">

  $(".breadcrumb").append('<li class="active"><a href="{{route('configurations.index')}}">Configurations</a></li>');
</script>
<script type="text/javascript" src="{{asset('js/admin_configuration.js')}}"></script>

  
@endsection

