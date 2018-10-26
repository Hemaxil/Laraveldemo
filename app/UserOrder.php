<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $table="user_order";
    protected $fillable=['user_id','billing_address_id','shipping_address_id','AWB_NO','payment_gateway_id','transaction_id','status','grand_total','shipping_charges','coupon_id'];

    public function get_order_details(){
    	return $this->hasMany('App\OrderDetail','order_id');
    }
}
