<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table="configuration";
    protected $fillable=['conf_key','conf_value','created_by','modified_by','status'];

    public function created_by_user(){
    	return $this->belongsTo('App\User','created_by');
    }

    public function modified_by_user(){
    	return $this->belongsTo('App\User','modified_by');
    }
}
