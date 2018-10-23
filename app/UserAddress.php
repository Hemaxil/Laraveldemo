<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table='user_address';
    protected $fillable=['user_id','address1','address2','state','city','country','zipcode'];

    public $timestamps=false;
}
