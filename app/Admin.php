<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'firstname','lastname', 'email', 'password','created_by','modified_by'
    ];


    
}
