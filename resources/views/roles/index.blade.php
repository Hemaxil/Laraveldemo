@extends('layouts.master')
@section('content')

<div class="panel panel-default">
	  <div class="panel-heading">Roles
	  	<a class="btn btn-primary glyphicon glyphicon-plus" href={{route('roles.create')}}></a>
      
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@empty($roles)
				<h5>No Roles Found</h5>
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
              <h3 class="box-title">Roles</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Role Name</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">		
					@foreach($roles as $role)
					<tr>
						<td><input type=checkbox class="checkbox" id={{$role->id}}></td>
						<td>{{$role->name}}</td>
						<td><a id='role.{{$role->id}}' href={{route('roles.edit',['role'=>$role->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a>
							<a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$role->id}}></i></a>
							<form id='delete{{$role->id}}' method="POST" action="{{route('roles.destroy',['role'=>$role->id])}}">
								@method('DELETE')
								@csrf
								<input style="display:none;" type="submit" class="btn btn-danger">

							</form></td>
					</tr>
					@endforeach
				</tbody>
              </table>
            </div>
            <!-- /.box-body -->
              <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{$roles->links()}}
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
	$(".delete_single").click(function(event){
		event.preventDefault();
		yes_del=confirm("Do you want to delete?");
		if(yes_del==1){
			$("#delete"+this.id).submit();
		}});
	delete_btn('{{route('roles.destroy_all')}}');


  $(".breadcrumb").append('<li class="active"><a href="{{route('roles.index')}}">Roles</a></li>');


</script>
	
@endsection
