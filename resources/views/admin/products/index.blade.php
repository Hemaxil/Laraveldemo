@extends('layouts.master')
@section('content')
	<div class="panel panel-default">
	  <div class="panel-heading">Product Details
	  	<a class="btn btn-primary glyphicon glyphicon-plus" href="{{route('products.create')}}"></a>
	  	<a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
	  </div>
	  </div>
	  <div class="panel-body">
	  	<div class="table-responsive">
		  	@empty($products)                            )
				<h5>No Products Found</h5>
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
              <h3 class="box-title">Products</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  	<th><input type=checkbox id="head" class="checkbox"></th>
                  	<th>Product Name</th>
                  	<th>Category</th>
                  	<th>Price</th>
                  	<th>Quantity</th>
                  	<th>Status</th>
					<th>Action</th>
                </tr>
                <tbody id="table_body">
					
							
					@foreach($products as $product)
					
					<tr id='{{$product->id}}'>
						<td><input type=checkbox class="checkbox" id={{$product->id}}></td>
						<td>{{$product->name}}</td>
						<td>
							
							@foreach($product->get_categories as $category)
								<p class='btn btn-primary'>{{$category->name}}</p>
							@endforeach
						</td>
						<td>{{$product->price}}</td>
						<td>{{$product->quantity}}</td>
						<td class="status" style="cursor: pointer;">
							@if($product->status==1)
								<a class="status-1-{{$product->id}}">Enabled</a>
								<a class="status-0-{{$product->id}}" hidden>Disabled</a>
							@else
								<a class="status-1-{{$product->id}}" hidden>Enabled</a>
								<a class="status-0-{{$product->id}}">Disabled</a>
							@endif
						</td>
						<td><a id='product.{{$product->id}}' href="{{route('products.edit',$product->id)}}" class="btn btn-primary glyphicon glyphicon-pencil" ></a>
							<a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$product->id}}></i></a>
							<form id='delete{{$product->id}}' method="POST" action="{{route('products.destroy',['product'=>$product->id])}}">
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
                {{$products->links()}}
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
	delete_btn('{{route('products.destroy_all')}}');
	update_status('{{route('products.update_status')}}');
	$(".breadcrumb").append('<li class="active"><a href="{{route('products.index')}}">Products  </a></li>');
</script>


@endsection