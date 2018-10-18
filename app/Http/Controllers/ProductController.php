<?php

namespace App\Http\Controllers;
use App\Product as Product;
use App\Category as Category;
use App\Product_Attribute_Assoc as Product_Attribute_Assoc;
use App\Product_Image as Product_Image;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProduct;
class ProductController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {   
        $products=Product::with('get_categories')->paginate(10);

        
        return view('admin.products.index',['page_header'=>'Products','page_desc'=>'Home'])->with('products',$products);
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

       $attributes='App\Product_attribute'::all();
       $categories=Category::with('parent_category')->get();
        $result=[];
        foreach($categories as $category){
            
            if($category->parent_category!=null){
                $parent=$category->parent_category->name;
                $name=$parent.">".$category->name;
                $result[$category->id]=$name;
            }else{
                if(count(Category::where('parent_id',$category->id)->get())==0)
                    $result[$category->id]=$category->name;
            }
        }
       
        
        return view('admin.products.create',['page_header'=>'Products','page_desc'=>'Add Product','attributes'=>$attributes,'categories'=>$result]);
    }
    public function edit($id)
    {
        $product=Product::with(['get_categories','get_images','get_attributes'])->findOrFail($id);
        
        $product_attributes=Product_Attribute_Assoc::with('get_attribute_name','get_attribute_value_name')->where('product_id',$id)->get();
        $attributes='App\Product_attribute'::all();
        $product_categories=$product->get_categories;
        $categories=Category::with('parent_category')->get();
        $result=[];
       
        foreach($categories as $category){
            
            if($category->parent_category!=null){
                $parent=$category->parent_category->name;
                $name=$parent.">".$category->name;
                $result[$category->id]=$name;
            }else{
                if(count(Category::where('parent_id',$category->id)->get())==0)
                    $result[$category->id]=$category->name;
            }
        }
        
      return view('admin.products.edit',['page_header'=>'Products','page_desc'=>'Edit Product','product'=>$product,'product_attributes'=>$product_attributes,'attributes'=>$attributes,'categories'=>$result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {   

        $future=($request->future==null)? "0":"1";
        

       $product=Product::create(['name'=>$request->name,'short_description'=>$request->short_description,'long_description'=>$request->long_description,'price'=>$request->price,'special_price'=>$request->special_price,'special_price_from'=>$request->special_price_from,'special_price_to'=>$request->special_price_to,'quantity'=>$request->quantity,'meta_title'=>$request->input('meta_title'),'meta_description'=>$request->input('meta_description'),'meta_keywords'=>$request->input('meta-keywords'),'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id,'future'=>$future]);
       $product->save();
       if($request->has(['attribute','attribute_value'])){
        for($i=0;$i<count($request->input('attribute'));$i++){
            $prod_assoc=Product_Attribute_Assoc::create(['product_id'=>$product->id,'product_attribute_id'=>($request->attribute)[$i],'product_attribute_value_id'=>($request->attribute_value)[$i]]);
            $prod_assoc->save();
        }
       }

       if($request->has('category')){
        foreach ($request->category as $category) {
            $product->get_categories()->save(Category::find($category));
        }
       }

       if($request->has('images')){
        foreach($request->images as $image){
            $path=$image->store('public/products');

            $image_name=explode('/',$path)[2];
            $prod_image=Product_Image::create(['image_name'=>$image_name,'status'=>'1','product_id'=>$product->id,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id]);
            $prod_image->save();

        }
       }
        return redirect()->route('products.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, $id)
    {
       
         $future=($request->future==null)? "0":"1";
       
        
        $product=Product::findOrFail($id);
        $product->fill(['name'=>$request->name,'short_description'=>$request->short_description,'long_description'=>$request->long_description,'price'=>$request->price,'special_price'=>$request->special_price,'special_price_from'=>$request->special_price_from,'special_price_to'=>$request->special_price_to,'quantity'=>$request->quantity,'meta_title'=>$request->input('meta_title'),'meta_description'=>$request->input('meta_description'),'meta_keywords'=>$request->input('meta_keywords'),'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id,'future'=>$future]);
       
        $product->save();

        
        Product_Attribute_Assoc::destroy($product->get_attributes()->pluck('id'));

        $product->get_categories()->detach();
        if($request->has(['attribute','attribute_value'])){
        for($i=0;$i<count($request->input('attribute'));$i++){
            if(($request->attribute)[$i]!='select'){
                 $prod_assoc=Product_Attribute_Assoc::create(['product_id'=>$product->id,'product_attribute_id'=>($request->attribute)[$i],'product_attribute_value_id'=>($request->attribute_value)[$i]]);
                $prod_assoc->save();
            }
           
        }
       }

       if($request->has('category')){
        foreach ($request->category as $category) {

            $product->get_categories()->save(Category::find($category));
            
        }
       }

       if($request->has('deleted_images')){
        if($request->deleted_images!=null){
            
            $ids=explode('_',$request->deleted_images);
            Product_Image::destroy($ids);
        }
      
       }

       if($request->has('images')){
        foreach($request->images as $image){
            $path=$image->store('public/products');
            $image_name=implode('/',$path)[2];
            $prod_image=Product_Image::create(['image_name'=>$image_name,'status'=>'1','product_id'=>$product->id,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id]);
            $prod_image->save();

        }
       }

        return redirect()->route('products.index');
    }


    public function get_attribute_values(Request $request){
        $attribute_values='App\Product_Attribute_Value'::where('product_attribute_id',$request->id)->select('id','attribute_value')->get();
        echo json_encode($attribute_values);
    }

    public function update_status(Request $request){

        $product=Product::findOrFail($request->id);
        $status=($product->status==1) ? '0' :'1';

        $product->status=$status;
        $product->save();
        echo json_encode([$request->id,$status]);

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
        //Product::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }

    public function destroy($id)
    {
       
        Product::destroy($id);
        return redirect()->route('products.index');
    }

    // public function delete_product_attribute_value(Request $request){
    //     //ProductAttributeValueController_Assoc::destroy($request->id);
    //     echo json_encode($request->id);
    // }

    //  public function delete_product_category(Request $request){
    //     $product=Product::find($request->product_id);
    //     $product->get_categories()->detach($request->id);
    //     echo json_encode($request->id);
    // }

    // public function delete_product_image(Request $request){
    //    Product_Image::destroy($request->id);
    //    echo json_encode($request->id);
    // }

    

}
