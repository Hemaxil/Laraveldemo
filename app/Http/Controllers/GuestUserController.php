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
		
		
	}

    public function index(Request $request){
    	
    	return view('index',['banners'=>$this->banners,'configuration'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->categories]);
    }

    
}
