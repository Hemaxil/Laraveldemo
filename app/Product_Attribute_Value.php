<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Attribute_Value extends Model
{
    protected $table="product_attribute_values";

   	protected $fillable=['product_attribute_id','attribute_value','created_by','modified_by'];

   	public function get_attribute(){
   		return $this->belongsTo('App\Product_attribute','product_attribute_id');
   	}
}
