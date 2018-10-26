<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table="order_details";
    protected $fillable=['order_id','product_id','quantity','amount'];

    public function get_product_details(){
    	return $this->belongsTo('App\Product','product_id');
    }
}
