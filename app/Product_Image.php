<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Image extends Model
{
    protected $table="product_images";

    protected $fillable=['image_name','created_by','modified_by','product_id','status'];
}
