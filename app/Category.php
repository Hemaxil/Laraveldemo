<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable=['name','parent_id','created_by','modified_by','status'];

	public function parent_category(){
		return $this->belongsTo('App\Category','parent_id','id');
	}


	public function child_category(){
		return $this->hasMany('App\Category','parent_id','id');
	}


	 public function get_products(){
    	return $this->belongsToMany('App\Product','product_categories','category_id','product_id');
    }

    
}
