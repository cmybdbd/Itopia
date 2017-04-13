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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');
Route::get('/create/{id}', 'OrderController@createOrder');
Route::get('/room', 'RoomController@manageRoom');
Route::get('/result/{id}','OrderController@getOrderDetail');

Route::get('/oauth_callback', 'WeChatController@call_back');
Route::get('/login', 'WeChatController@auth');

Route::get('/server', 'WeChatController@check_server');

Route::get('/lock/callback', 'LockController@callback');

Route::get('/sendCode', 'SMSController@sendCode');
Route::get('/idAuth', 'IDAuthController@IDauth');
