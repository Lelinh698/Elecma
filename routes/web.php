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


Route::get('/', 'Auth\LoginController@getLogin')->name('login');
Route::post('/', 'Auth\LoginController@postLogin');
Route::get('/register', 'Auth\RegisterController@getRegister')->name('register');
Route::get('/logout', 'Auth\LoginController@getLogout');

Route::resource('customer', 'CustomerController');
//Route::group('customer')
Route::get('get_customer_list', 'CustomerController@getCustomerList');
Route::get('get_customer_info', 'CustomerController@getCustomerInfo');
Route::get('statistic', 'StatisticController@index');
Route::group(['prefix' => 'customer'],function(){
    Route::post('/bill/pay', 'BillController@pay');
});

Route::resource('employee', 'EmployeeController');
Route::get('view_list_customer', 'CustomerController@getCustomerListView');

Route::resource('bill', 'BillController');
Route::post('bill/payment', 'BillController@createPayment')->name('payment.online');
Route::get('vnpay/return', 'BillController@vnpayReturn')->name('vnpay.return');
Route::get('get_bill_info', 'BillController@getBillInfo');
//Route::post('update_bill', 'BillController@store');
Route::get('get_bill_info', 'BillController@getBillInfo');
Route::get('customer/{id}/bill/search', 'BillController@search');
Route::get('update_electric_number', 'BillController@update_electric_number')->name('update_electric_number');

Route::get('customer/{id}/meter', 'MeterController@get_current_year_number');
Route::get('customer/{id}/meter/search', 'MeterController@search');
Route::get('abnormal/{month}', 'MeterController@abnormal_electricity');
Route::get('abnormal/{customer_id}/{year}/{month}', 'MeterController@getCustomerMeterDetail');
Route::post('get_latest_number', 'MeterController@get_latest_number');

//Route::get('admin', 'AdminController@index');
Route::group(['prefix' => 'admin'],function(){
    Route::get('/', 'AdminController@index');
    Route::get('/department', 'AdminController@getDepartment');
    Route::get('/customer', 'AdminController@getCustomer');
    Route::get('/employee', 'AdminController@getEmployee');
    Route::get('/bill', 'AdminController@getBill');
    Route::get('/update_electric_price', 'AdminController@getUpdatePriceForm');
    Route::post('/update_electric_price', 'AdminController@storeElectricPrice');
});

Route::resource('departments', 'DepartmentController');