<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable=['name','parent_id','created_by','modified_by','status'];

	public function parent_category(){
		return $this->belongsTo('App\Category','parent_id','id');
	}
    
}
