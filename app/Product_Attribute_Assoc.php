<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Attribute_Assoc extends Model
{
    protected $table="product_attributes_assoc";

    protected $fillable=['product_id','product_attribute_id','product_attribute_value_id'];

    public function get_product(){
    	return $this->belongsTo('App\Product','product_id');
    }

    public function get_attribute_name(){
    	return $this->belongsTo('App\Product_attribute','product_attribute_id');
    }

    public function get_attribute_value_name(){
    	return $this->belongsTo('App\Product_Attribute_Value','product_attribute_value_id');
    	
    }
}
