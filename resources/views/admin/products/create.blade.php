
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
        <h3 class="box-title">Create Product</h3>

	    {{-- <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
	    </div> --}}
    </div>
        <!-- /.box-header -->
        {!! Form::open(['route' => 'products.store','enctype'=>"multipart/form-data"]) !!}
    <div class="box-body">
    	
      	<div class="row">
	        <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('name', 'Product Name',['class'=>'control-label'])}}
		           {{Form::text ('name','',['class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('sku', 'SKU',['class'=>'control-label'])}}
		           {{Form::text ('sku','',['class'=>'form-control'])}} 
		        </div>
		    </div>
		    
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				{{Form::label('short_description', 'Short Description',['class'=>'control-label'])}}
		        {{Form::text ('short_description','',['class'=>'form-control'])}} 
			</div>
			 <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('quantity','Quantity',['class'=>'control-label'])}}
		           {{Form::number('quantity','',['class'=>'form-control'])}}
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				{{Form::label('long_description','Long Description',['class'=>'control-label'])}}
				{{Form::textarea('long_description','',['class'=>'form-control','rows'=>'4'])}}
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('price', 'Price',['class'=>'control-label'])}}
		           {{Form::number ('price','',['step'=>'0.01','class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price', 'Special Price',['class'=>'control-label'])}}
		           {{Form::number ('special_price','',['step'=>'0.01','class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price_from', 'Special Price from',['class'=>'control-label'])}}
		           {{Form::date ('special_price_from','',['class'=>'form-control','min'=>date('Y-m-d')])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('special_price_to', 'Special Price To',['class'=>'control-label'])}}
		           {{Form::date ('special_price_to','',['class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		           {{Form::label('meta_title', 'Meta Title',['class'=>'control-label'])}}
		           {{Form::text ('meta_title','',['class'=>'form-control'])}} 
		        </div>
		    </div>
		    <div class="col-md-6">
		         <div class="form-group">
		           {{Form::label('meta_description', 'Meta Description',['class'=>'control-label'])}}
		           {{Form::text ('meta_description','',['class'=>'form-control'])}} 
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">

				{{Form::label('meta_keywords','Meta Keywords',['class'=>'control-label'])}}
				{{Form::textarea('meta_keywords','',['class'=>
				'form-control','rows'=>2])}}
				
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				{{Form::label('future','Future',['class'=>'control-label'])}}
				{{Form::checkbox('future')}}
				
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<b>Add Attribute</b>
				<span class="pull-right" style="padding-bottom: 10px;"><a class="btn btn-primary glyphicon glyphicon-plus add_attribute" href="" ></a></span>
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
					<tr>
						<td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td>
						<td id='add_attribute'>
							<select class='form-control attribute_select col-md-4' name='attribute[]' id='attribute'>
								<option value='select'>Select</option>
								@foreach($attributes as $attribute)
									<option value='{{$attribute->id}}'>{{$attribute->name}}</option>
								@endforeach
							</select></td>
						<td class='attr_value'><select class='form-control' id='attribute_value' name='attribute_value[]'><option value='Select'>Select</option></select></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					{{-- <span> --}}
		           {{Form::label('category[]', 'Category',['class'=>'control-label'])}}
		           <select class='form-control' name='category[]' id='multi' multiple>
		          	@foreach($categories as $key=>$value)
		          		<option value={{$key}}>{{$value}}</option>
		          	@endforeach
		          </select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">
				{{Form::label('images[]','Product Images',['class'=>'control-label'])}}
				<span class="pull-right" style="padding-bottom: 10px;" >
				<a class="btn btn-primary glyphicon glyphicon-plus upload_images" href=""></a></span>
			
				<table  class="table table-bordered" id="uploaded_images">
					<tr>
						<th></th>
						<th>Images</th>
					</tr>
				</table>
			</div>
		</div>
	</div>


	          
        <!-- /.box-body -->
    <div class="box-footer">
      
      	{!! Form::submit($value='Create',['class'=>'btn btn-primary']) !!}
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
					var selected_row=$(this).parent('td').parent('tr');
					var row=$(this).parent('td').attr('id');
					$.ajax({
						url:"{{route('products.get_attr_value')}}",
						headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
						type:'get',
						dataType:'json',
						data:{'id':id},
					}).done(function(result){
						console.log(result);
						var options="<option value='select'>Select</option>";
						selected_row.children("td.attr_value").children("select").children().remove();

						$.each(result,function(){
							options+="<option value="+this.id+">"+this.attribute_value+"</option>";
							console.log(this.id);
						});
						selected_row.children("td.attr_value").children("select").append(options);

					});
		
		});

		var add_attribute=0;
		$(".add_attribute").click(function(event){
				event.preventDefault();
				add_attribute+=1;
				$(".attribute-table").append("<tr><td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td><td id='"+add_attribute+"'><select class='form-control attribute_select col-md-4' name='attribute[]' id='attribute'><option value='select'>Select</option>@foreach($attributes as $attribute)<option value='{{$attribute->id}}'>{{$attribute->name}}</option>@endforeach</select></td><td class='attr_value'><select class='form-control' id='attribute_value' name='attribute_value[]'><option value='Select'>Select</option></select></td></tr>");
				
				});
		});
		/*$(".add_category").click(function(event){
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
				
			});

		});*/
		$(document).on('click',".remove",function(event){
			event.preventDefault();
			$(this).parent().parent('tr').remove();
		});
		$(document).on('change',"#special_price_from",function(){
			let special_price_from=($(this).val());
			$("#special_price_to").attr('min',special_price_from);
		});
		$("#multi").multiselect({
    		disableIfEmpty:true,
    		onChange:function(option,checked){
    		console.log(option,checked);
    		}
    	});
		$(".upload_images").click(function(event){

			event.preventDefault();
			$("#uploaded_images").append("<tr><td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td><td><input type='file' name='images[]' class='form-control'></td></tr>");

		});
				
	</script>

 
   


	
@endsection