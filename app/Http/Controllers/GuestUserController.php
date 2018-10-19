<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
class GuestUserController extends Controller
{ 
	public function __construct(){
		$this->banners='App\Banner'::where('status','1')->get();
		$this->configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
		
		$this->parent_categories='App\Category'::with('child_category')->where(['status'=>'1','parent_id'=>null])->get();
		
			
	}

    public function index(Request $request){
    	
    	return view('index',['banners'=>$this->banners,'configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories]);
    }

	
   public function getCategoryTree($level = null, $prefix = '') {
	    $rows = 'App\Category'::where('parent_id', $level)->get();
	    $category ='';
	    if (count($rows) > 0) {
	        foreach ($rows as $row) {
	            $category.=$prefix . $row->name."\n" ;
	            
	            $category.= $this->getCategoryTree($row->id, $prefix . '>');
	        }
	    }
	    return $category;
	}

	public function printCategoryTree(Request $request) {
	    echo ($this->getCategoryTree($request->id));
	}

	public function get_child_categories(Request $request){
	
		$parent='App\Category'::where('id',$request->id);
		$child='App\Category'::where('parent_id',$request->id)->union($parent)->get();
		if(count('App\Category'::find($request->id)->child_category()->get())>0){
			echo json_encode($child);
		}else{
			echo json_encode($child);
		}
}
	
	public function get_featured_items(Request $request,$id){
	 	
		$category='App\Category'::find($id);
		$child=$category->child_category()->pluck('id');
		if(count($child)>0){
			$products='App\Category'::with('get_products.get_images')->where('id',$child)->get();
		}else{
			$products='App\Category'::with('get_products.get_images')->where('id',$id)->get();
			
		}


		//dd(count($products->first()->get_products));
		
		
		
		return view('frontend.get_products',['configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'category_products'=>$products]);


	}


	public function get_product_details(Request $request,$id){
		$product='App\Product'::with('get_categories','get_images','get_attributes')->findOrFail($id);

		

		return view('frontend.product_details',['configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->parent_categories,'product'=>$product]);
	}
    
}
