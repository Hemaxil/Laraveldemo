<div class="left-sidebar">
	<h2>Category</h2>
	<div class="panel-group category-products" id="accordian">
		<!--category-productsr-->
		@foreach($parent_categories as $parent_category)
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
							{{$parent_category->name}}
						</a>
					</h4>
				</div>
				<div id="sportswear" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							@foreach($categories as $category)
								@if($category->parent_id==$parent_category->id)
									<li><a href="#">{{$category->name}} </a></li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endforeach
		
		{{-- <div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a href="#">Kids</a></h4>
			</div>
		</div> --}}
		
	</div><!--/category-products-->

	
{{-- 	<div class="price-range"><!--price-range-->
		<h2>Price Range</h2>
		<div class="well text-center">
			 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
			 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
		</div>
	</div><!--/price-range--> --}}
	
	<div class="shipping text-center"><!--shipping-->
		<img src="eshopper/images/home/shipping.jpg" alt="" />
	</div><!--/shipping-->

</div>