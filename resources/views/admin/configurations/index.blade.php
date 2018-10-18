@extends('layouts.master')
@section('content')
	<div class="panel panel-default">
	  <div class="panel-heading">Configuration Details
	  	<a class="btn btn-primary glyphicon glyphicon-plus" href={{route('configurations.create')}}></a>
      
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@empty($configurations)
				<h5>No Configurations Found</h5>
			@endempty
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
			 <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Configurations</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Configuration Key</th>
					<th>Configuration Value</th>
					<th>Created by</th>
					<th>Modified by</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">
					
							
					@foreach($configurations as $configuration)
					<tr>
						<td><input type=checkbox class="checkbox" id={{$configuration->id}}></td>
						<td>{{$configuration->conf_key}}</td>
						<td>{{$configuration->conf_value}}</td>
						<td>{{$configuration->created_by_user->firstname}}</td>
						<td>{{$configuration->modified_by_user->firstname}}</td>
						<td class="status" style="cursor:pointer ;">
							@if($configuration->status==1)
								<a class="status-1-{{$configuration->id}}">Enabled</a>
								<a class="status-0-{{$configuration->id}}" hidden>Disabled</a>
							@else
								<a class="status-1-{{$configuration->id}}" hidden>Enabled</a>
								<a class="status-0-{{$configuration->id}}">Disabled</a>
							@endif
						</td>
						<td><a id='configuration.{{$configuration->id}}' href={{route('configurations.edit',['configuration'=>$configuration->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a></td>
					</tr>
					@endforeach
							
					
				</tbody>
              </table>
            </div>
            <!-- /.box-body -->
              <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{$configurations->links()}}
              </ul>
            </div>
          </div>
		</div>
	  </div>
	</div>

	 
@endsection

@section('additional_js')
<script type="text/javascript" src={{asset("js/roles.js")}}></script>
<script type="text/javascript">
	delete_btn('{{route('configurations.destroy')}}');
	update_status('{{route('configurations.update_status')}}');
	$(".breadcrumb").append('<li class="active"><a href="{{route('configurations.index')}}">Configurations</a></li>');
</script>
	
@endsection

