<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','GuestUserController@index')->name('guest_home');
Route::get('user/login','Auth\LoginController@showUserLoginForm')->name('user.login');
Route::group(['middleware' => ['role:superadmin'],'prefix'=>'admin'], function () {
    Route::resource('roles','RoleController')->except(['destroy']);
	Route::delete('roles/delete','RoleController@delete')->name('roles.destroy');
	Route::resource('users','UserController')->except(['destroy']);
    Route::delete('users/delete','UserController@delete')->name('users.destroy');
    Route::patch('users/', 'UserController@update_status')->name('users.update_status');
});

Route::group(['middleware' => ['role:admin|superadmin'],'prefix'=>'admin'], function () {
	Route::get('/', function () { return view('admin.index');
	})->name('admin.home');


    Route::resource('configurations','ConfigurationController')->except(['destroy']);
    Route::patch('configurations/', 'ConfigurationController@update_status')->name('configurations.update_status');
    Route::delete('configurations/delete','ConfigurationController@delete')->name('configurations.destroy');


	Route::resource('banners','BannerController')->except(['destroy']);
    Route::delete('banners/delete','BannerController@delete')->name('banners.destroy');
    Route::patch('banners/', 'BannerController@update_status')->name('banners.update_status');

    Route::get('categories/get_categories','CategoryController@get_all_categories')->name('categories.get_all');
    Route::delete('categories/delete_all','CategoryController@delete')->name('categories.destroy_all');
    Route::resource('categories','CategoryController');
    
    Route::patch('categories/', 'CategoryController@update_status')->name('categories.update_status');

    Route::delete('products/delete','ProductController@delete')->name('products.destroy_all');
    Route::resource('products','ProductController')->except(['show']);
    Route::get('products/get_attribute_values','ProductController@get_attribute_values')->name('products.get_attr_value');
    
    Route::patch('products/', 'ProductController@update_status')->name('products.update_status');
    Route::delete('products/delete_attributes','ProductController@delete_product_attribute')->name('products.delete_product_attribute');
    Route::delete('products/delete_categories','ProductController@delete_product_category')->name('products.delete_product_category');
    Route::delete('products/delete_image','ProductController@delete_product_image')->name('products.delete_product_image');


   
    Route::resource('product_attributes','Product_Attribute_Controller')->except(['show','create']);
    Route::delete('product_attributes/delete','Product_Attribute_Controller@delete')->name('product_attributes.destroy_all');
    Route::get('product_attributes/get_attribute','Product_Attribute_Controller@get_attribute')->name('product_attributes.get_attribute');

    
   

    Route::delete('product_attributes_values/delete','Product_Attribute_Value_Controller@delete')->name('product_attributes_values.destroy_all');
    Route::resource('product_attributes_values','Product_Attribute_Value_Controller')->except(['show']);
    


    Route::resource('coupons','CouponController')->except(['show']);
    Route::delete('coupons/delete_all','CouponController@delete')->name('coupons.destroy_all');
    Route::patch('coupons/', 'CouponController@update_status')->name('coupons.update_status');
});

