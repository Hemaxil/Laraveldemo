<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_attribute extends Model
{
    protected $table="product_attributes";

    protected $fillable=['name','created_by','modified_by'];

    public function get_attribute_value(){
    	return $this->hasMany('App\Product_Attribute_Value','product_attribute_id');
    }


  
}
// lluminate/Database/QueryException with message 'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`demo`.`ProductAttributeValueControllers_assoc`, CONSTRAINT `ProductAttributeValueControllers_assoc_ProductAttributeValueController_id_foreign` FOREIGN KEY (`ProductAttributeValueController_id`) REFERENCES `ProductAttributeValueControllers` (`id`) ON DELETE CASC) (SQL: insert into `ProductAttributeValueControllers_assoc` (`ProductAttributeValueController_id`, `product_id`) values (3, 1))'
