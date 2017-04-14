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
Route::get('/', function () {
    return redirect('home');
});

Route::get('/oauth_callback', 'WeChatController@call_back');
Route::get('/payment/callback', 'WeChatController@payment_call_back');
Route::get('/server', 'WeChatController@check_server');


Route::post('/order/create', 'OrderController@storeOrder');

Route::group(['middleware' => 'auth'], function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/create/{uid}/{rid}', 'OrderController@createOrder');
    Route::get('/room', 'RoomController@manageRoom');
    Route::get('/result/{id}','OrderController@getOrderDetail');
    Route::get('/comment/{id}', 'CommentController@create');
    Route::get('/commentResult', 'CommentController@finish');

});
Route::group(['middleware' => ['web','wechat.oauth']], function () {
    Route::get('/login', 'WeChatController@auth')->name('login');
});


Route::get('/lock/callback', 'LockController@callback');

Route::get('/sendCode/{mblNo}', 'SMSController@sendCode');
