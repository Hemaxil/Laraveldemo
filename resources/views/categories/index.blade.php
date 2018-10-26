@extends('layouts.master')
@section('content')
	<div class="panel panel-default">
	  <div class="panel-heading">Categories
	  	<a class="btn btn-primary glyphicon glyphicon-plus" href={{route('categories.create')}}></a>
      
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@if(count($categories)==0)
				<h5>No Categories Found</h5>
			@endif
			@if(Session::has('success'))
			<div class="alert alert-success" role="alert">
				{{Session::get('success')}}
			</div>
			@endif
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
              <h3 class="box-title">Categories</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Category Name</th>
					<th>Parent Category</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">
					
							
					@foreach($categories as $category)
					<tr>
						<td><input type=checkbox class="checkbox" id={{$category->id}}></td>
						<td>{{$category->name}}</td>
						<td>
							@isset($category->parent_category)
								{{$category->parent_category->name}}</td>
							@else
								No Parent Category 
							@endisset
						<td class="status" style=" cursor: pointer;">
							@if($category->status==1)
								<a class="status-1-{{$category->id}}">Enabled</a>
								<a class="status-0-{{$category->id}}" hidden>Disabled</a>
							@else
								<a class="status-1-{{$category->id}}" hidden>Enabled</a>
								<a class="status-0-{{$category->id}}">Disabled</a>
							@endif
						</td>
						<td><a id='category.{{$category->id}}' href={{route('categories.edit',['category'=>$category->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a>
							<a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$category->id}}></i></a>
							<form id='delete{{$category->id}}' method="POST" action="{{route('categories.destroy',['category'=>$category->id])}}">
								@method('DELETE')
								@csrf
								<input style="display:none;" type="submit" class="btn btn-danger">

							</form>
						</td>
					</tr>
					@endforeach
							
					
				</tbody>
              </table>
            </div>
            <!-- /.box-body -->
              <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{$categories->links()}}
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
		console.log("Heello");
		yes_del=confirm("Do you want to delete?");
		if(yes_del==1){
			console.log("Heello");
			$("#delete"+this.id).submit();
		}
		

	});
	delete_btn('{{route('categories.destroy_all')}}');
	update_status('{{route('categories.update_status')}}');
	$(".breadcrumb").append('<li class="active"><a href="{{route('categories.index')}}">Categories</a></li>');
</script>
	
@endsection

