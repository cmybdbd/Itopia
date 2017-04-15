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

Route::get('/oauth_callback', 'WeChatController@call_back');
Route::get('/payment/callback', 'WeChatController@payment_call_back');
Route::get('/server', 'WeChatController@check_server');


Route::post('/order/create', 'OrderController@storeOrder');
Route::post('/comment/create', 'CommentController@store');
Route::get('/test', function (){
    echo (time() % (24*60*60) > 12 * 60*60 )? 't':'f';
    echo (time() % (24*60*60));
    return ;
});
Route::get('test2', function (){
    echo (time() % (24*60*60));
    return ;
});

Route::group(['middleware' => 'auth'], function (){
    Route::get('/home', 'HomeController@index');
    Route::get('/create/{uid}/{rid}', 'OrderController@createOrder');
    Route::get('/result/{id}','OrderController@getOrderDetail');
    Route::get('/comment/{id}', 'CommentController@create');
    Route::get('/commentResult', 'CommentController@finish');
    Route::get('/orderList/{id}', 'OrderController@getOrderList');

    Route::get('/manage/room', 'RoomController@manageRoom');
    Route::get('/manage/order', 'OrderController@manageOrder');
});
Route::group(['middleware' => ['web','wechat.oauth']], function () {
    Route::get('/login', 'WeChatController@auth');
});


Route::get('/lock/callback', 'LockController@callback');

Route::get('/sendCode', 'SMSController@sendCode');
Route::get('/idAuth', 'IDAuthController@IDauth');
Route::group(['prefix' => 'lock'], function(){
    Route::get('updatePassword', "LockController@api_update_password");
});

Route::group(['prefix' => 'itopia'], function()
{
    Route::get('/oauth_callback', 'WeChatController@call_back');
    Route::get('/payment/callback', 'WeChatController@payment_call_back');
    Route::get('/server', 'WeChatController@check_server');


    Route::post('/order/create', 'OrderController@storeOrder');
    Route::post('/comment/create', 'CommentController@store');
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
Route::group(['middleware' => ['web','wechat.oauth'],'prefix'=>'itopia'], function () {
    Route::get('/login', 'WeChatController@auth')->name('login');
});


Route::group(['prefix' => 'itopia'], function()
{
Route::get('/lock/callback', 'LockController@callback');

Route::get('/sendCode', 'SMSController@sendCode');
Route::get('/idAuth', 'IDAuthController@IDauth');
});
Route::group(['prefix' => 'itopia/lock'], function(){
    Route::get('updatePassword', "LockController@api_update_password");
});

