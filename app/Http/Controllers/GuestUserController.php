<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
class GuestUserController extends Controller
{ 
	public function __construct(){
		$this->banners='App\Banner'::where('status','1')->get();
		$this->configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
		
		$this->parent_categories='App\Category'::where(['status'=>'1','parent_id'=>null])->get();
		$this->categories='App\Category'::where('parent_id','<>',null)->where('status','1')->get();
		//dd('App\Category'::find(1)->child_category);
			
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

    
}
