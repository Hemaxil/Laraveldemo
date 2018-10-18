@extends('layouts.master')
@section('content')
	<div class="card">
  		<div class="card-header">User Details</div>
  		<div class="card-body">
  			{{$user->firstname}}  {{$user->lastname}}

  		</div>
  		<div class="card-footer"></div>
	</div>
@endsection