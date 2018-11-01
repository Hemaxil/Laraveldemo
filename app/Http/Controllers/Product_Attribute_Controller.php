<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product_attribute as Product_attribute;
use Session;
class Product_Attribute_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_attributes=Product_attribute::paginate(10);

        return view('admin.product_attributes.index',['title'=>'Product Atrributes','page_header'=>'Product Attributes','page_desc'=>'Details','attributes'=>$product_attributes]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate(['name'=>'required|alpha_num']);
        $attribute=Product_attribute::create(['name'=>$request->name,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id]);
        $attribute->save();
        Session::flash('success','New Attribute created!!');
        return redirect()->route('product_attributes.index');
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
        $request->validate(['name'=>'required|alpha_num']);
        $attribute=Product_attribute::findOrFail($id);
        $attribute->fill(['name'=>$request->name,'modified_by'=>$request->user()->id]);
        $attribute->save();
        Session::flash('Attribute updated!!');

        return redirect()->route('product_attributes.index');

    }

   
     /*

    Delete multiple attributes.
    Input :list of ids to be deleted
    Output:list of deleted ids 
    */
     public function delete(Request $request)
    {
        $ids=explode("+",$request->ids);
        $ids = array_filter($ids);
        Product_attribute::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }

    /*

     Send all attributes to product create and edit views.
    */
    public function get_attribute(Request $request){
        $product=Product_attribute::findOrFail($request->id);
        echo json_encode($product);
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
       
        Product_attribute::destroy($id);
        Session::flash('Attribute deleted!!');
        return redirect()->route('product_attributes.index');
    }
}
