@extends('layouts.master')
@section('content')
	<div class="panel panel-default">
	  <div class="panel-heading">Product Attribute Details
	  	<a class="btn btn-primary glyphicon glyphicon-plus add_attr" href="{{route('product_attributes_values.create')}}"></a>
      
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@empty($attribute_values)                           )
				<h5>No Attributes Found</h5>
			@endempty
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
              <h3 class="box-title">Attribute Values</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Attribute Name</th>
                  	<th>Attribute Value</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">
					
							
					@foreach($attribute_values as $attribute_value)
					
					<tr id='{{$attribute_value->id}}'>
						<td><input type=checkbox class="checkbox" id={{$attribute_value->id}}></td>
						<td>{{$attribute_value->get_attribute->name}}</td>
						<td>{{$attribute_value->attribute_value}}</td>
						<td><a id='attribute.{{$attribute_value->id}}' href="{{route('product_attributes_values.edit',$attribute_value->id)}}" class="btn btn-primary glyphicon glyphicon-pencil" ></a>
							<a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$attribute_value->id}}></i></a>
							<form id='delete{{$attribute_value->id}}' method="POST" action="{{route('product_attributes_values.destroy',['product_attributes_value'=>$attribute_value->id])}}">
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
                {{$attribute_values->links()}}
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
	delete_btn('{{route('product_attributes_values.destroy_all')}}');
	//update_status('{{route('configurations.update_status')}}');
	$(".breadcrumb").append('<li class="active"><a href="{{route('product_attributes_values.index')}}">Product Attribute Values</a></li>');
</script>


@endsection

