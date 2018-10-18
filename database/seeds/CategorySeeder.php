<?php

use Illuminate\Database\Seeder;
use App\Category as Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=['Desktops','Laptops & Notebooks'];
        foreach($categories as $category){
        	$obj=Category::create(['name'=>$category,'parent_id'=>0,'created_by'=>1,'modified_by'=>1,'status'=>'1']);
        	$obj->save();
        }
        
    }
}
