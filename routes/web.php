<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\CustomerListController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\AnalizeController;
use App\Http\Controllers\ChecksController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

 Route::get('customerlist/create_tech', 'CustomerListController@create_tech')->middleware('auth');
 Route::post('customerlist/save_tech', 'CustomerListController@save_tech')->middleware('auth');
 Route::get('customerlist/credit_tech', 'CustomerListController@credit_tech')->middleware('auth');
 Route::post('customerlist/credit_save_tech', 'CustomerListController@credit_save_tech')->middleware('auth');
 Route::get('customerlist/check_tech', 'CustomerListController@check_tech')->middleware('auth');
 Route::post('customerlist/check_save_tech', 'CustomerListController@check_save_tech')->middleware('auth');
 Route::get('customerlist/storage_tech', 'CustomerListController@storage_tech')->middleware('auth');
 Route::post('customerlist/storage_tech_search', 'CustomerListController@storage_tech_search')->middleware('auth');
 Route::resource('customerlist', 'CustomerListController')->middleware('auth');

Route::get('customer_ac/discountitem', 'CustomerAccountController@discountitem')->middleware('auth');
Route::get('customer_ac/discountreg', 'CustomerAccountController@discountreg')->middleware('auth');
Route::post('customer_ac/discountreg_create', 'CustomerAccountController@discountreg_create')->middleware('auth');
Route::get('customer_ac/discountget', 'CustomerAccountController@discountget')->middleware('auth');
Route::post('customer_ac/discountget_api', 'CustomerAccountController@discountget_api')->middleware('auth');
Route::post('customer_ac/discountget_check', 'CustomerAccountController@discountget_check')->middleware('auth');
Route::post('customer_ac/discount_search', 'CustomerAccountController@discount_search')->middleware('auth');

Route::get('customer_ac/pdfcreate/{id}', 'CustomerAccountController@createPDF')->middleware('auth');
Route::get('customer_ac/pdf_tech/{id}', 'CustomerAccountController@pdf_tech')->middleware('auth');
Route::get('customer_ac/pdfcreate_tech/{id}', 'CustomerAccountController@pdfcreate_tech')->middleware('auth');
Route::resource('customer_ac', 'CustomerAccountController')->middleware('auth');

Route::get('check/products', 'ChecksController@products')->middleware('auth');
Route::get('check/getproducts', 'ChecksController@getproducts')->middleware('auth');
Route::get('check/getproductlist', 'ChecksController@getproductlist')->middleware('auth');
Route::post('check/getproductlist_api', 'ChecksController@getproductlist_api')->middleware('auth');
Route::post('check/techproductlist_api', 'ChecksController@techproductlist_api')->middleware('auth');
Route::post('check/getqueuelist_api', 'ChecksController@getqueuelist_api')->middleware('auth');
Route::post('check/getproductlist_save', 'ChecksController@getproductlist_save')->middleware('auth');
Route::post('check/storage_search', 'ChecksController@storage_search')->middleware('auth');
Route::get('check/storage_products', 'ChecksController@storage_products')->middleware('auth');
Route::get('check/product_prices', 'ChecksController@product_prices')->middleware('auth');

Route::post('check/updateproducts', 'ChecksController@updateproducts')->middleware('auth');
Route::resource('check', 'ChecksController')->middleware('auth');
Route::resource('analize', 'AnalizeController')->middleware('auth');
Route::resource('adminpanel', 'AdminController')->middleware('auth');
Route::resource('deadline', 'DeadlineController')->middleware('auth');

Route::get('useraccount/{user}', 'CustomerListController@userAccount')->middleware('auth');
Route::post('/search', 'AnalizeController@search')->middleware('auth');
Route::post('searchcustomer', 'CustomerListController@search')->middleware('auth');


Auth::routes();

Route::resource('pricelist', 'PriceController')->middleware('auth');
Route::post('expences/expences_search', 'ExpencesController@expences_search')->middleware('auth');
Route::post('expences/paydebt', 'ExpencesController@paydebt')->middleware('auth');
Route::get('expences/debt', 'ExpencesController@debt')->middleware('auth');
Route::resource('expences', 'ExpencesController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('returns/create2', 'ReturnController@create2')->middleware('auth');
Route::resource('returns', 'ReturnController')->middleware('auth');
