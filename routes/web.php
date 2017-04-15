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
    return redirect()->route('home');
});

Route::get('itopia/oauth_callback', 'WeChatController@call_back');
Route::get('itopia/payment/callback', 'WeChatController@payment_call_back');
Route::get('itopia/server', 'WeChatController@check_server');


Route::post('itopia/order/create', 'OrderController@storeOrder');
Route::post('itopia/comment/create', 'CommentController@store');
Route::get('/test', function (){
    echo (time() % (24*60*60) > 12 * 60*60 )? 't':'f';
    echo (time() % (24*60*60));
    return ;
});
Route::get('test2', function (){
    echo (time() % (24*60*60));
    return ;
});

Route::group(['middleware' => 'auth','prefix'=>'itopia'], function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/create/{uid}/{rid}', 'OrderController@createOrder');
    Route::get('/result/{id}','OrderController@getOrderDetail');
    Route::get('/comment/{id}', 'CommentController@create');
    Route::get('/commentResult', 'CommentController@finish');
    Route::get('/orderList/{id}', 'OrderController@getOrderList');

    Route::get('/manage/room', 'RoomController@manageRoom');
    Route::get('/manage/order', 'OrderController@manageOrder');
});
Route::group(['middleware' => ['web','wechat.oauth'], 'prefix'=>'itopia'], function () {
    Route::get('/login', 'WeChatController@auth')->name('login');
});


Route::get('itopia/lock/callback', 'LockController@callback');

Route::get('itopia/sendCode', 'SMSController@sendCode');
Route::get('itopia/idAuth', 'IDAuthController@IDauth');
Route::group(['prefix' => 'itopia/lock'], function(){
    Route::get('updatePassword', "LockController@api_update_password");
});
