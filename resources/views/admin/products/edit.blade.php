
@extends('layouts.master')
@section('content')

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

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Product</h3>

	  
    </div>
        <!-- /.box-header -->

        {!! Form::model($product,['method'=>'PUT','route' => ['products.update',$product->id],'enctype'=>"multipart/form-data",'id'=>'product_form']) !!}
    <div class="box-body">
    	
      	<div class="row">
	        <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('name', 'Product Name',['class'=>'control-label'])}}
		           {{Form::text ('name',null,['class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('sku', 'SKU',['class'=>'control-label'])}}
		           {{Form::text ('sku',null,['class'=>'form-control'])}} 
		        </div>
		    </div>
		    
		   
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				{{Form::label('short_description', 'Short Description',['class'=>'control-label'])}}
		        {{Form::text ('short_description',null,['class'=>'form-control'])}} 
			</div>
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('quantity','Quantity',['class'=>'control-label'])}}
		           {{Form::number('quantity',null,['class'=>'form-control'])}}
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				{{Form::label('long_description','Long Description',['class'=>'control-label'])}}
				{{Form::textarea('long_description',null,['class'=>'form-control','rows'=>'4'])}}
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('price', 'Price',['class'=>'control-label'])}}
		           {{Form::number ('price',null,['step'=>'0.01','class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price', 'Special Price',['class'=>'control-label'])}}
		           {{Form::number ('special_price',null,['step'=>'0.01','class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price_from', 'Special Price from',['class'=>'control-label'])}}
		           {{Form::date ('special_price_from',null,['class'=>'form-control','min'=>date('Y-m-d'),])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price_to', 'Special Price To',['class'=>'control-label'])}}
		           {{Form::date ('special_price_to',null,['class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">
				{{Form::label('future','Future',['class'=>'control-label'])}}
				{{Form::checkbox('future',null)}}
				
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<b>Add Attribute</b>
				<span class='pull-right' style="padding-bottom: 10px;"><a class="btn btn-primary glyphicon glyphicon-plus add_attribute" href=""></a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<table class="attribute-table table table-bordered">
					<tr>
						<th></th>
						<th>Attribute</th>
						<th>Value</th>
					</tr>
					@foreach($product_attributes as $product_attribute)
						<tr>
							@if($loop->first)
							<td></td>
							@else
							<td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td>
							@endif
							<td id='add_attribute'>
								<select class='form-control attribute_select col-md-4' name='attribute[]' id='attribute'>
									<option value='select'>Select</option>
									@foreach($attributes as $attribute)
										@if($product_attribute->get_attribute_name->name==$attribute->name)
											<option value='{{$attribute->id}}' selected>{{$attribute->name}}</option>
										@else
											<option value='{{$attribute->id}}' >{{$attribute->name}}</option>
										@endif

									@endforeach
								</select>
							</td>
							<td class='attr_value'><select class='form-control' id='attribute_value' name='attribute_value[]'><option value='{{$product_attribute->get_attribute_value_name->id}}'>{{$product_attribute->get_attribute_value_name->attribute_value}}</option>



							</select></td>
						
						</tr>
					@endforeach
					@if(count($product_attributes)==0)
						<tr>
							<td></td>
							<td id='add_attribute'>
								<select class='form-control attribute_select col-md-4' name='attribute[]' id='attribute'>
									<option value='select'>Select</option>
									@foreach($attributes as $attribute)
										<option value='{{$attribute->id}}'>{{$attribute->name}}</option>
									@endforeach
								</select></td>
							<td class='attr_value'><select class='form-control' id='attribute_value' name='attribute_value[]'><option value='Select'>Select</option></select></td>
						</tr>
					@endif
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				
		           
		          <div class="form-group">
					{{-- <span> --}}
			           {{Form::label('category[]', 'Category',['class'=>'control-label'])}}
			           {{Form::select('category[]',$categories,$product->get_categories,['class'=>'multi form-control','multiple'=>'multiple'])}}
					
				</div>
			</div>
		</div>
		{{-- <div class="row">
			<div class="col-sm-8">
				<table id="category-table" class="table table-bordered">
					<tr>
						<th></th>
						<th>Category</th>
					</tr>
					
					@foreach($product->get_categories as $categories)
						<tr>
							<td><a id="delete_product_category_{{$categories->id}}" class="btn btn-danger glyphicon glyphicon-trash" href=""></a></span></td>
							<td>{{$categories->name}}</td>
							
						</tr>
					@endforeach
					<tr>
					
				</table>
			</div>
			
		</div> --}}
		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('meta_title','Meta Title',['class'=>'control-label'])}}
		           {{Form::text ('meta_title',null,['class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		         <div class="form-group">
		           {{Form::label('meta_description', 'Meta Description',['class'=>'control-label'])}}
		           {{Form::text ('meta_description',null,['class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">

				{{Form::label('meta_keywords','Meta Keywords',['class'=>'control-label'])}}
				{{Form::textarea('meta_keywords',null,['class'=>
				'form-control','rows'=>2])}}
				
			</div>
		</div>

		
		<div class="row">

			<div class="form-group col-md-6">
				{{Form::label('images[]','Product Images',['class'=>'control-label'])}}
				<span class="pull-right" style="padding-bottom: 10px;">
				<a class="btn btn-primary glyphicon glyphicon-plus upload_images" href="" ></a></span>
				<table id="uploaded_images" class="table table-bordered">
					
					
						<tr>
							<th></th>
							<th>Images</th>
						</tr>
						@foreach($product->get_images as $image)
							<tr>
								@if($loop->first)
								<td></td>
								@else
								<td><a class=" remove btn btn-danger glyphicon glyphicon-trash" id="delete_{{$image->id}}" href=""></a></span></td>
								@endif
								<td><input type='file' name='images[]' value='{{$image->image_name}}' class='form-control'><img src={{asset('storage/products/'.$image->image_name)}} height=70px width=70px>

								</td>
								
							</tr>
						@endforeach
				

				</table>
				<div id="deleted_images">
					<input name="deleted_images" type=hidden value="">
				</div>
			</div>
		</div>
	</div>


	          
        <!-- /.box-body -->
    <div class="box-footer">
      
      	{!! Form::submit($value='Update',['class'=>'btn btn-primary']) !!}
    </div>
     
</div>


@endsection

@section('additional_js')
	
	<script type="text/javascript" src="{{asset('js/product.js')}}"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('change',".attribute_select",function(){
					console.log("Hello");
					let id=$(this).val();
					var row=$(this).parent('td').attr('id');
					$.ajax({
						url:"{{route('products.get_attr_value')}}",
						headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
						type:'get',
						dataType:'json',
						data:{'id':id},
					}).done(function(result){
						console.log(result);
						var options="";
						$.each(result,function(){
							options+="<option value="+this.id+">"+this.attribute_value+"</option>";
							console.log(this.id);
						});
						$("tr").children("td.attr_value ").children("select").append(options);

					});
		
		});

		var add_attribute=0;
		$(".add_attribute").click(function(event){
				event.preventDefault();
				add_attribute+=1;
				$(".attribute-table").append("<tr><td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td><td id='"+add_attribute+"'><select class='form-control attribute_select col-md-4' name='attribute[]' id='attribute'><option value='select'>Select</option>@foreach($attributes as $attribute)<option value='{{$attribute->id}}'>{{$attribute->name}}</option>@endforeach</select></td><td class='attr_value'><select class='form-control' id='attribute_value' name='attribute_value[]'><option value='Select'>Select</option></select></td></tr>");
				
				});
		});
		$(".add_category").click(function(event){
			event.preventDefault();
			$.ajax({
				url:'{{route('categories.get_all')}}',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				type:'get',
				dataType:'json',
			}).done(function(result){
				console.log(result);
				var row="<tr><td></td><td><select class='form-control' name='category[]' id='multi' multiple>";
				$.each(result,function(key,value){
					console.log(key,value);
					row+="<option value="+key+">"+value+"</option>";
				});
				row+="</select></td></tr>";
				$("#category-table").append(row);
				// $("#multi").multiselect({
				// 	disableIfEmpty:true,
				// });
			});

		});
		$(document).on('click',".remove",function(event){
			event.preventDefault();
			input=this.id;
			input=input.split('_');
			$(this).parent().parent('tr').remove();
			input_val=$("#deleted_images input").val();
			$("#deleted_images input").attr('value',input[1]+"_"+input_val);
		});
		$(".multi").multiselect({
    		disableIfEmpty:true,
    		onChange:function(option,checked){
    		console.log(option,checked);
    	}
    });
		$(document).on('change',"#special_price_from",function(){
			let special_price_from=($(this).val());
			$("#special_price_to").attr('min',special_price_from);
		})
		$(".upload_images").click(function(event){

			event.preventDefault();
			$("#uploaded_images").append("<tr><td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td><td><input type='file' name='images[]' class='form-control'></td></tr>");

		});
		
	</script>

 <script type="text/javascript" src="{{asset('js/admin_product.js')}}"></script>
   


	
@endsection