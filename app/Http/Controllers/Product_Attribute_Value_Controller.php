<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product_attribute as Product_attribute;
use App\Product_Attribute_Value as Product_Attribute_Value;

class Product_Attribute_Value_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attribute_values=Product_Attribute_Value::with('get_attribute')->paginate(10);
        return view('admin.product_attributes_values.index',['title'=>'Attribute Values','page_desc'=>'Attribute Values','page_header'=>'Products','attribute_values'=>$attribute_values]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes=Product_attribute::pluck('name','id');
        return view('admin.product_attributes_values.create',['title'=>'Attribute Values','page_desc'=>'Attribute Values','page_header'=>'Products','attributes'=>$attributes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(['attribute'=>'required',
                            'attribute_value'=>'required|alpha_num']);
        $attribute_value=Product_Attribute_Value::create(['product_attribute_id'=>$request->attribute,'attribute_value'=>$request->attribute_value]);
        $attribute_value->save();

        return redirect()->route('product_attributes_values.index');

    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute_value=Product_Attribute_Value::findOrFail($id);
        $attributes=Product_attribute::pluck('name','id');
         return view('admin.product_attributes_values.edit',['title'=>'Attribute Values','page_desc'=>'Attribute Values','page_header'=>'Products','attribute_value'=>$attribute_value,'attributes'=>$attributes]);
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
        $request->validate(['attribute_value'=>'required|alpha_num',
            'product_attribute_id'=>'required']);
        $attribute_value_object=Product_Attribute_Value::findOrFail($id);
        $attribute_value_object->fill(['product_attribute_id'=>$request->product_attribute_id,'attribute_value'=>$request->attribute_value]);
       
        $attribute_value_object->save();

        return redirect()->route('product_attributes_values.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function delete(Request $request)
    {
        $ids=explode("+",$request->ids);
        $ids = array_filter($ids);
        Product_Attribute_Value::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }


    public function destroy($id)
    {
       
        Product_Attribute_Value::destroy($id);
        return redirect()->route('product_attributes_values.index');
    }

}
