<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Product as Product;
use App\Category as Category;
use App\Configuration as Configuration;
use App\Banner as Banner;
use App\Product_Attribute_Assoc as Product_Attribute_Assoc;
class GuestUserController extends Controller
{ 
	public function __construct(){
		$this->banners='App\Banner'::where('status','1')->get();
		$this->configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
		
		$this->parent_categories='App\Category'::with('child_category')->where(['status'=>'1','parent_id'=>null])->get();
		
			
	}

	/*

		Guest User Login page

	*/
    public function index(Request $request){
    	
    	$products=Product::with('get_images','get_categories')->where(['future'=>'1','status'=>'1'])->get();
    	return view('index',['banners'=>$this->banners,'configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'featured_items'=>$products]);
    }

    /*

		Get child categories of the parent category
		Input:category id
		Output: id of the child categories along with the input category

	*/
	public function get_child_categories(Request $request){
	
		$parent='App\Category'::where('id',$request->id);
		$child='App\Category'::where(['parent_id'=>$request->id,'status'=>'1'])->union($parent)->get();
		
		if(count('App\Category'::find($request->id)->child_category()->get())>0){
			echo json_encode($child);
		}else{
			echo json_encode($child);
		}
}
	/*

	Get all products under a particular category.If the category selected is a parent category , then get all products from all the child categories of the parent.
	Input:category id
	Output:Get all products
	
	*/
	public function get_featured_items(Request $request,$id){
	 	
		$category='App\Category'::find($id);
		$child_categories=$category->child_category()->pluck('status','id');
		$child=[];
		foreach($child_categories as $key=>$value){
			if($value=='1'){
			array_push($child,$key);
					}
			
		}

		if(count($child)>0){
			$products='App\Category'::with('get_products.get_images')->whereIn('id',$child)->get();
		}else{
			$products='App\Category'::with('get_products.get_images')->where('id',$id)->get();
			
		}
		


		return view('frontend.get_products',['configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'category_products'=>$products]);


	}

	/*

	Product details view.
	Retrieve all details related to product-images,attributes.
	Input:product id
	Output:product 

	*/
	public function get_product_details(Request $request,$id){


		$product=Product::with('get_categories','get_images','get_attributes')->findOrFail($id);
		$original_price=0;
		if($product->special_price_from && $product->special_price_to){
			$date=date('Y-m-d');
			if($date<=$product->special_price_to && $date>=$product->special_price_from){
			$original_price=$product->price;
				$product->price=$product->special_price;

			}
		}
		$product_attributes=Product_Attribute_Assoc::with('get_attribute_name','get_attribute_value_name')->where('product_id',$id)->get();

		return view('frontend.product_details',['configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'product'=>$product,'product_attributes'=>$product_attributes,'original_price'=>$original_price]);
	}
    
}
