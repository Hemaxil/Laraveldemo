<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable=['code','no_of_uses','created_by','modified_by','status','percent_off'];
}
