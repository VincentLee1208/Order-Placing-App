<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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




Route::get('/', function () {
	if (session()->has('user_email')) {
			 return redirect()->route('dashboard');
		}else{
			 return view('login');
		}
})->name('login_default');

Route::get('/all_users','DashboardController@all_users')->name('users');
Route::post('/joinnow_save','DashboardController@joinnow_save')->name('joinnow_save');
Route::post('/joinnow_update','DashboardController@joinnow_update')->name('joinnow_update');
Route::get('/delete_user/{id}','DashboardController@delete_user')->name('delete_user');
Route::get('/joinnow_save', function () {
    return redirect()->route('login_default');
});

Route::prefix('product')->group(function () {
	Route::any('/add2cart','DashboardController@add2cart')->name('add2cart');
	Route::any('/add2cart_reorder','DashboardController@add2cart_reorder')->name('add2cart_reorder');
	Route::any('/clearCart',function(){
		Session::forget('cart');
		Session::flash('message','Cart cleared!');
		return redirect()->back();
	})->name('clearCart');
	Route::any('/clearSingle/{id}','DashboardController@clearSingle')->name('clearSingle');
	Route::any('/checkout','DashboardController@checkout')->name('checkout');
});

// my favourite
Route::any('/all_products','DashboardController@favourite')->name('favourite');
Route::any('/history','DashboardController@history')->name('history');
Route::any('/tracking','DashboardController@tracking')->name('tracking');
Route::any('/update_to_tracking','DashboardController@update_to_tracking')->name('update_to_tracking');

//change
Route::any('/change_date', 'DashboardController@change_date')->name('change_date');

Route::any('/order_update','DashboardController@order_update')->name('order_update');
Route::any('/update_note','DashboardController@update_note')->name('update_note');
Route::any('/quick_order','DashboardController@quick_order')->name('quick_order');
Route::any('/complete_order/{id}','DashboardController@complete_order')->name('complete_order');

Route::any('/archive','DashboardController@archive')->name('archive');
Route::any('/task','DashboardController@task')->name('task');
Route::any('/print','DashboardController@print')->name('print');
Route::get('sortable','DashboardController@sortable')->name('sortable');

//admin's products
Route::get('/products','DashboardController@products')->name('products');
Route::post('/product_save','DashboardController@product_save')->name('product_save');
Route::post('/product_update','DashboardController@product_update')->name('product_update');
Route::get('/product_delete/{id}','DashboardController@product_delete')->name('product_delete');


Route::get('/task','DashboardController@task')->name('task');
Route::post('/task_save','DashboardController@task_save')->name('task_save');
Route::post('/task_update','DashboardController@task_update')->name('task_update');
Route::get('/complete_task/{id}','DashboardController@complete_task')->name('complete_task');
Route::get('/task_delete/{id}','DashboardController@task_delete')->name('task_delete');

Route::get('/rep','DashboardController@rep')->name('rep');
Route::post('/rep_save','DashboardController@rep_save')->name('rep_save');
Route::post('/rep_update','DashboardController@rep_update')->name('rep_update');
Route::get('/delete_rep/{id}','DashboardController@delete_rep')->name('delete_rep');

Route::get('/joinnow_save', function () {
    return redirect()->route('login_default');
});

//admin's orders
Route::get('/add_to_favourite','DashboardController@orders')->name('orders');
Route::post('/order_save','DashboardController@order_save')->name('order_save');
Route::post('/order_update','DashboardController@order_update')->name('order_update');
Route::get('/order_delete/{id}','DashboardController@order_delete')->name('order_delete');
Route::get('/delete_complted_orders','DashboardController@delete_complted_orders')->name('delete_complted_orders');
Route::get('/create_order','DashboardController@create_order')->name('create_order');


//admin's categories
Route::get('/categories','DashboardController@categories')->name('categories');
Route::post('/category_save','DashboardController@category_save')->name('category_save');
Route::post('/category_update','DashboardController@category_update')->name('category_update');
Route::get('/category_delete/{id}','DashboardController@category_delete')->name('category_delete');

Route::any('/marketing','DashboardController@marketing')->name('marketing');
Route::any('/promoted','DashboardController@promoted')->name('promoted');

Route::any('/promoted_products','DashboardController@promoted_products')->name('promoted_products');

Route::any('/welcome_text','DashboardController@welcome_text')->name('welcome_text');

Route::any('/thankyou','DashboardController@thankyou')->name('thankyou');

//admin's favourite for admin
Route::post('/add2fav','DashboardController@add2fav')->name('add2fav');
Route::get('/favourite_list','DashboardController@favourite_list')->name('favourite_list');
Route::get('/favourite_list/{id}','DashboardController@favourite_list_individual_id')->name('favourite_list_individual_id');
Route::post('/favourite_list','DashboardController@favourite_list_individual')->name('favourite_list_individual');
Route::post('/delete_saved_product/{client_id}','DashboardController@delete_saved_product')->name('delete_saved_product');

Route::get('/profile','DashboardController@profile')->name('profile');
Route::post('/save_profile','DashboardController@save_profile')->name('save_profile');
Route::get('/delete_location/{id}','DashboardController@delete_location')->name('delete_location');
Route::get('/lost_password','UserController@lost_password')->name('lost_password');
Route::post('/check_lostpassword','UserController@check_lostpassword')->name('check_lostpassword');
Route::get('/reset_password/{reset_token}','UserController@reset_password')->name('reset_password');
Route::post('/reset_password_check','UserController@reset_password_check')->name('reset_password_check');


Route::any('/download','DashboardController@download')->name('download');


Route::get('/cronjob','DashboardController@cronjob')->name('cronjob');








Route::post('/lock','UserController@check_login')->name('check_login');
Route::get('/lock', function () {
    return view('lock');
});
Route::get('/logout','UserController@logout')->name('logout');
Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');
