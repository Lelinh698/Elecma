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

//Route::get('/', function () {
//   return view('auth.login');
//});


Route::get('/', 'Auth\LoginController@getLogin');
Route::post('/', 'Auth\LoginController@postLogin');
Route::get('/logout', 'Auth\LoginController@getLogout');

Route::resource('customer', 'CustomerController');
Route::resource('employee', 'EmployeeController');
Route::resource('bill', 'BillController');

Route::get('customer/{id}/meter', 'MeterController@get_current_year_number');
Route::get('customer/{id}/meter/search', 'MeterController@search');
Route::get('customer/{id}/bill/search', 'BillController@search');
Route::get('update_electric_number', 'BillController@update_electric_number');
Route::get('get_customer_list', 'CustomerController@getCustomerList');
Route::get('get_customer_info', 'CustomerController@getCustomerInfo');
//Route::post('update_bill', 'BillController@store');
