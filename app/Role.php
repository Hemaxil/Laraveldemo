<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
	use HasRoles;
    
    protected $guard_name = 'web';

    protected $fillable=['name','guard_name'];
 

}
