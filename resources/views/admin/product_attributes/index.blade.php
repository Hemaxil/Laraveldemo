@extends('layouts.master')
@section('content')
	<div class="panel panel-default">
	  <div class="panel-heading">Product Attribute Details
	  	<a class="btn btn-primary glyphicon glyphicon-plus add_attr" ></a>
      
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@empty($attributes)
				<h5>No Attributes Found</h5>
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
              <h3 class="box-title">Attributes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Attribute Name</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">
					
							
					@foreach($attributes as $attribute)
					
					<tr id='{{$attribute->id}}'>
						<td><input type=checkbox class="checkbox" id={{$attribute->id}}></td>
						<td contenteditable>{{$attribute->name}}</td>
						<td><a id='attribute.{{$attribute->id}}'  class="btn btn-primary glyphicon glyphicon-pencil" ></a>
							<a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$attribute->id}}></i></a>
							<form id='delete{{$attribute->id}}' method="POST" action="{{route('product_attributes.destroy',['product_attribute'=>$attribute->id])}}">
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
                {{$attributes->links()}}
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
	delete_btn('{{route('product_attributes.destroy_all')}}');
	//update_status('{{route('configurations.update_status')}}');
	$(".breadcrumb").append('<li class="active"><a href="{{route('product_attributes.index')}}">Product Attributes</a></li>');
</script>

<script type="text/javascript">
	$(".delete_single").click(function(event){
		event.preventDefault();
		yes_del=confirm("Do you want to delete?");
		if(yes_del==1){
			$("#delete"+this.id).submit();
		}});
	$(document).on('click',".remove",function(event){
			event.preventDefault();
			$(this).parent().parent('tr').remove();
		});
	$(".add_attr").click(function(){
		console.log("Hello");
		$("#table_body").append("@include('admin.product_attributes.create')");
	});

	$("a[id*='attribute.'").click(function(){
		let inp_id=(this.id).split('.')[1];
		$("tr[id='"+inp_id+"']").children('td').remove();
		$.ajax({
			url:"{{route('product_attributes.get_attribute')}}",
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{'id':inp_id},
            type: "get",
            dataType:"json",
		}).done(function(result){
			console.log(result);
			$("tr[id='"+inp_id+"']").append("<td><input type=checkbox class='checkbox' id="+result.id+"></td><td><form method='POST' action='http://localhost:8000/admin/product_attributes/"+result.id+"'accept-charset='UTF-8' id='update-"+result.id+"'><input name='_method' type='hidden' value='PUT'><input name='_token' type='hidden' value={{csrf_token()}}><input class='form-control' name='name' type='text' value='"+result.name+"'></form></td><td><input class='btn btn-primary' type='submit' value='Update' form='update-"+result.id+"'></td>");
			console.log(result);
		});
		
		// $("tr[id='show."+inp_id+"']").hide();
		// $("tr[id='edit."+inp_id+"']").show();
		
	});
</script>
@endsection

