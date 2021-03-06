<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Category as Category;
use Session;


/*

CRUD for Product Categories

*/
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $categories=Category::with('parent_category')->paginate(10);
        
        return view('categories.index',['page_header'=>'Categories','page_desc'=>'Home'])->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        //$parent_categori=Category::whereNull('parent_id')->where('status','1')->pluck('name','id');
        $parent_categori=Category::whereNull('parent_id')->where('status','1')->pluck('name','id');
        //$parent_category->prepend('None',null);
        $parent_category=array_add($parent_categori,'0','None');
       
        return view('categories.create',['page_header'=>'Categories','page_desc'=>'Add Category'])->with('parent_category',$parent_category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate(['name'=>'required']);
       
        if ($request->parent=='0'){
            $parent_category=null;
        }else{
            $parent_category=$request->parent;
        }
        $category=Category::firstOrNew(['name'=>$request->name,'parent_id'=>$parent_category,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id,'status'=>$request->status]);
        $category->save();
        Session::flash('success','New category created!!');
        return redirect()->route('categories.index');
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::findOrFail($id);
        $parent_categori=Category::whereNull('parent_id')->where('id','<>',$id)->where('status','1')->pluck('name','id');
        $parent_category=array_add($parent_categori,'0','None');
        return view('categories.edit',['page_header'=>'Categories','page_desc'=>'Edit Category','category'=>$category])->with('parent_category',$parent_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate(['name'=>'required']);
        $category=Category::findOrFail($id);
        if($request->parent=='0'){
            $parent=null;
        }else
        $parent=$request->parent;
        $category->fill(['name'=>$request->name,'parent_id'=>$parent,'status'=>$request->status]);
        $category->save();
        Session::flash('success','Category updated!!');

        return redirect()->route('categories.index');
    }

     /*

    Delete multiple categories.
    Input :list of ids to be deleted
    Output:list of deleted ids 
    */
    public function delete(Request $request)
    {
        
        $ids=explode("+",$request->ids);
        $ids = array_filter($ids);
        Category::destroy($ids);
        $ids =json_encode($ids); 
        return($ids) ;
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Category::destroy($id);
        Session::flash('success','Category deleted!!');
        return redirect()->route('categories.index');
    }
    /*
    Make category active /inactive
    Input:category id
    Output:category id , status
    
    */
    public function update_status(Request $request){

        $configuration=Category::findOrFail($request->id);
        $status=($configuration->status==1) ? '0' :'1';

        $configuration->status=$status;
        $configuration->save();
        echo json_encode([$request->id,$status]);

    }

    public function get_all_categories(Request $request){
        $categories=Category::with('parent_category')->get();
        $result=[];
        foreach($categories as $category){
            
            if($category->parent_category!=null){
                $parent=$category->parent_category->name;
                $name=$parent.">".$category->name;
                $result[$category->id]=$name;
            }else{
                $result[$category->id]=$category->name;
            }
        }
        
        echo (json_encode($result));
    }
}
