@extends('layouts.frontend_master')

@section('content')
@if (count($errors) > 0)
  				<div class="alert alert-danger">
	    		{{-- 	<strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
	    			<ul>
	       				@foreach ($errors->all() as $error)
	         				<li>{{ $error }}</li>
	       				@endforeach
	    			</ul>
  				</div>
			@endif
<div class="category-tab shop-details-tab"><!--category-tab-->
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
			<li><a href="#addaddress" data-toggle="tab">Add Address</a></li>
			<li><a href="#showaddress" data-toggle="tab">Show Address</a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="details" >
			<div class="col-sm-offset-1">
				<p>First name: {{auth()->user()->firstname}}</p>
		  		<p>Last name:{{auth()->user()->lastname}}</p>
		  		<p>Email Address:{{auth()->user()->email}}</p>
		  	</div>
		</div>
	
	
		<div class="tab-pane fade " id="addaddress" >
			<div class="col-sm-offset-1">
				{{Form::open(['route' => ['accounts.store_address',auth()->user()->id],'id'=>'user_address_form'])}}

					<div class="form-group col-sm-10">
						{{Form::label('address1','Address Line 1',['class'=>'control-label'])}}
						
						{{Form::text('address1','',['class'=>'form-control'])}}
						
					</div>
					<div class="form-group col-sm-10">
						{{Form::label('address2','Address Line 2',['class'=>'control-label'])}}
						{{Form::text('address2','',['class'=>'form-control'])}}
					</div>
					<div class="form-group col-sm-10">
						{{Form::label('city','City',['class'=>'control-label'])}}
						{{Form::text('city','',['class'=>'form-control'])}}
					</div>
					<div class="form-group col-sm-10">
						{{Form::label('state','State',['class'=>'control-label'])}}
						{{Form::text('state','',['class'=>'form-control'])}}
					</div>
					<div class="form-group col-sm-10">
						{{Form::label('country','Country',['class'=>'control-label'])}}
						{{Form::text('country','',['class'=>'form-control'])}}
					</div>
					<div class="form-group col-sm-10">
						{{Form::label('zipcode','ZipCode',['class'=>'control-label'])}}
						{{Form::number('zipcode','',['class'=>'form-control'])}}
					</div>
					<div class="form-group col-sm-10">
						{{Form::submit('Add Address',['class'=>'btn btn-primary'])}}
					</div>

				{{Form::close()}}
			</div>
		</div>

		<div class="tab-pane fade " id="showaddress" >
			<div class="col-sm-offset-1">
				@if(count($user_address)>0)
					@foreach($user_address as $address)
						{{$address->address1}},{{$address->address2}}{{$address->city}}{{$address->state}}{{$address->country}}{{$address->zipcode}}
					@endforeach
				@else
					<p role="alert">No Address Found!!</p>
				@endif
			</div>
		</div>
	</div>
</div>



@endsection
@section('additional_js')
<script type="text/javascript" src="{{asset('js/user_address.js')}}"></script>
@endsection
