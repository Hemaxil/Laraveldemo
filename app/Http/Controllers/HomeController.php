<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->banners='App\Banner'::where('status','1')->get();
        $this->configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
        
        $this->parent_categories='App\Category'::where(['status'=>'1','parent_id'=>null])->get();
        $this->categories='App\Category'::where('parent_id','<>',null)->where('status','1')->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        return view('index',['banners'=>$this->banners,'configurations'=>$this->configuration,'parent_categories'=>$this->parent_categories,'categories'=>$this->categories]);
    }


    
}
