<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="product";

    protected $fillable=['name','sku','short_description','long_description','price','special_price','special_price_from','special_price_to','status','quantity','meta_title','meta_description','meta_keywords','created_by','modified_by','future'];
    
    public function get_categories(){
    	return $this->belongsToMany('App\Category','product_categories','product_id','category_id');
    }


    public function get_images(){
    	return $this->hasMany('App\Product_Image','product_id');
    }

    public function get_attributes(){
    	return $this->hasMany('App\Product_Attribute_Assoc','product_id');
    }

   

//$prod_attr=Product::find(1)->product_categories()->save(Category::find(4))

}
