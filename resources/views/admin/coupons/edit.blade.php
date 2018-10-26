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
            {!! Form::model($coupon,['method'=>'PUT','route' => ['coupons.update',$coupon->id],'class'=>'form-horizontal','coupon_form']) !!}
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    {{Form::label('code', 'Coupon Code',['class'=>'col-sm-2 control-label'])}}
                    <div class="col-sm-10">
                      {{Form::text ('code',null,['class'=>' form-control'])}}
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    {{Form::label('percent_off', 'Percent Off',['class'=>'col-sm-2 control-label'])}}
                    <div class="col-sm-10">
                      {{Form::number ('percent_off',null,['step'=>'0.01','class'=>' form-control'])}}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    {{Form::label('no_of_uses', 'No of Uses',['class'=>'col-sm-2 control-label'])}}
                    <div class="col-sm-10">
                      {{Form::number ('no_of_uses',null,['class'=>' form-control'])}}
                    </div>
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

  $(".breadcrumb").append('<li class="active"><a href="{{route('coupons.index')}}">Coupons</a></li>');
</script>
<script type="text/javascript" src="{{asset('js/admin_coupon.js')}}"></script>
  
@endsection
