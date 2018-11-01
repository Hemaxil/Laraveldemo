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


/* Auth Routes*/
Auth::routes();
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update
    ');
/*

Home pages

*/

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','GuestUserController@index')->name('guest_home');

/*
Login routes
*/
Route::get('user/login','Auth\LoginController@showUserLoginForm')->name('user.login');
Route::get('facebook_login','SocialLoginController@redirectToProvider')->name('user.facebook');
Route::get('facebook_login/callback','SocialLoginController@handleProviderCallback')->name('user.facebookcallback');

/*
Frontend routes
*/

Route::get('categorytree/','GuestUserController@get_child_categories')->name('categorytree');

Route::get('products/{id}','GuestUserController@get_featured_items')->name('get_featured_items');
Route::get('products/{id}/details','GuestUserController@get_product_details')->name('get_product_details');

//Frontend for authenticated routes

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home/checkout/pay_with_paypal','PaymentController@payPaypal')->name('payment.paypal');
    Route::get('/home/myaccountdetails/{id}','HomeController@showAccountsPage')->name('accounts.details');
    Route::post('/home/myaccountdetails/{id}','HomeController@storeAddress')->name('accounts.store_address');
    Route::post('/addtocart/{productid}','HomeController@addItemToCart')->name('accounts.addToCart');
    Route::get('/home/mycart','HomeController@showCart')->name('accounts.get_cart');
    Route::post('/home/mycart/update','HomeController@updateCart')->name('accounts.update_cart');
    Route::delete('/home/mycart','HomeController@deleteCart')->name('accounts.delete');
    Route::post('/home/mycart/get_discount','HomeController@getDiscount')->name('accounts.get_discount');
    Route::get('/home/checkout','HomeController@checkoutView')->name('accounts.get_checkout');
    Route::post('/home/checkout','HomeController@saveCheckoutData')->name('accounts.save_checkout');
    Route::get('/home/checkout/order-review','HomeController@showOrderReview')->name('accounts.order_review');
    Route::post('/home/checkout/payment-select','HomeController@decidePayment')->name('decide_payment');
    Route::get('/home/saveorder','HomeController@saveOrder')->name('accounts.save_order');
    Route::get('/home/view_orders','HomeController@viewOrders')->name('accounts.view_orders');
    Route::delete('/home/view_orders/{id}','HomeController@cancelOrder')->name('accounts.cancel_order');
    
    Route::get('home/checkout/payment_paypal','PaymentController@paypalSuccess')->name('paypal_success');

});


/*

Admin Panel routes

*/
/*
For superadmin

*/
Route::group(['middleware' => ['role:1'],'prefix'=>'admin'], function () {
    Route::delete('roles/delete','RoleController@delete')->name('roles.destroy_all');
    Route::resource('roles','RoleController')->except('show');
    Route::delete('users/delete','UserController@delete')->name('users.destroy_all');
	Route::resource('users','UserController');
    Route::patch('users/', 'UserController@update_status')->name('users.update_status');
});
/*

For admin and superadmin
*/
Route::group(['middleware' => ['role:1|2'],'prefix'=>'admin'], function () {

/*
Reports routes
*/
    Route::get('/pdf/orders','AdminController@generatePDFOrders')->name('pdf_orders');
    Route::get('/pdf/users','AdminController@generatePDFUsers')->name('pdf_users');
    Route::get('/pdf/new_users','AdminController@generatePDFNewUsers')->name('pdf_new_users');
    Route::get('/pdf/new_orders','AdminController@generatePDFNewOrders')->name('pdf_new_orders');
    Route::get('get_sales_graph','AdminController@get_sales_data')->name('sales_data');
   

/*
Configuration routes
*/
	Route::get('/', 'AdminController@index')->name('admin.home');
    Route::delete('configurations/delete','ConfigurationController@delete')->name('configurations.destroy_all');
    Route::resource('configurations','ConfigurationController')->except('show');
    Route::patch('configurations/', 'ConfigurationController@update_status')->name('configurations.update_status');
    
/*
Banners routes
*/
	
    Route::delete('banners/delete','BannerController@delete')->name('banners.destroy_all');
    Route::resource('banners','BannerController')->except('show');
    Route::patch('banners/', 'BannerController@update_status')->name('banners.update_status');

/*

Categories
*/
    Route::get('categories/get_categories','CategoryController@get_all_categories')->name('categories.get_all');
    Route::delete('categories/delete_all','CategoryController@delete')->name('categories.destroy_all');
    Route::resource('categories','CategoryController')->except('show');
    Route::patch('categories/', 'CategoryController@update_status')->name('categories.update_status');


/*
Product routes
*/
    Route::delete('products/delete','ProductController@delete')->name('products.destroy_all');
    Route::resource('products','ProductController')->except(['show']);
    Route::get('products/get_attribute_values','ProductController@get_attribute_values')->name('products.get_attr_value');
    Route::patch('products/', 'ProductController@update_status')->name('products.update_status');
    // Route::delete('products/delete_attributes','ProductController@delete_product_attribute')->name('products.delete_product_attribute');
    // Route::delete('products/delete_categories','ProductController@delete_product_category')->name('products.delete_product_category');
    // Route::delete('products/delete_image','ProductController@delete_product_image')->name('products.delete_product_image');

/*
Product attributes
*/

    Route::delete('product_attributes/delete','Product_Attribute_Controller@delete')->name('product_attributes.destroy_all');
    Route::resource('product_attributes','Product_Attribute_Controller')->except(['show','create']);
    Route::get('product_attributes/get_attribute','Product_Attribute_Controller@get_attribute')->name('product_attributes.get_attribute');

    
   
/*
Product attribute routes
*/
    Route::delete('product_attributes_values/delete','Product_Attribute_Value_Controller@delete')->name('product_attributes_values.destroy_all');
    Route::resource('product_attributes_values','Product_Attribute_Value_Controller')->except(['show']);
    
/*
Coupons routes

*/
    Route::delete('coupons/delete_all','CouponController@delete')->name('coupons.destroy_all');
    Route::resource('coupons','CouponController')->except(['show']);
    Route::patch('coupons/', 'CouponController@update_status')->name('coupons.update_status');
});

