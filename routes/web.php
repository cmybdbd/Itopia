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

Route::get('/manage/order', 'OrderController@manageOrder');
Route::group(['middleware' => 'auth'], function (){

    Route::post('/order/create', 'OrderController@storeOrder');
    Route::post('/order/recreate', 'OrderController@restoreOrder');
    Route::post('/comment/create', 'CommentController@store');
    Route::post('/savePhone/{phone}', function($phone){
        \App\User::savePhone($phone, \Illuminate\Support\Facades\Auth::id());
    });

    Route::get('/getIsNightBooked/{id}','OrderController@getOrderDetail');
    Route::get('/timetest', 'OrderController@test');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dayPage','HomeController@dayPage');
    Route::get('/nightPage','HomeController@nightPage');
    Route::get('/dayPageLocation','HomeController@dayPageLocation');
    Route::get('/nightPageLocation','HomeController@nightPageLocation');
    Route::get('/getDayRooms/{name}','HomeController@getDayRooms');
    Route::get('/getNightRooms/{name}','HomeController@getNightRooms');

    Route::get('/create/{uid}/{rid}', 'OrderController@createOrder');
    Route::get('/create/day/{uid}/{rid}/{day}', 'OrderController@createDayOrder');
    Route::get('/create/night/{uid}/{rid}/{day}', 'OrderController@createNightOrder');
    Route::get('/result/{id}','OrderController@getOrderDetail');
    Route::get('/isNightBooked/{rid}/{day}', 'RoomController@isRoomNightBooked');
    Route::post('/order/complete','OrderController@completeOrder');

    Route::get('/comment/{id}', 'CommentController@create');
    Route::get('/commentResult', 'CommentController@finish');

    Route::get('/orderList/{id}', 'OrderController@getOrderList');
    Route::get('/isFirstOrder/{id}', 'OrderController@isFirstOrder');
    Route::get('/getOrderList', 'HomeController@orderList');
    Route::get('/getOrderByDay/{rid}/{day}', 'HomeController@getOrderByDay');

    Route::get('/manage/room', 'RoomController@manageRoom');
    Route::get('/manage/room/{rid}', 'RoomController@manageRoomById');
    Route::post('/manage/room', 'RoomController@updateRoomInfo');
    //Route::get('/manage/order', 'OrderController@manageOrder');
    Route::get('/manage/fakeOrder','OrderController@fakeOrderCreate');
    Route::get('/manage/roomUpdate','RoomController@roomUpdate');
    Route::get('/manage/anotherOrder', 'OrderController@getAnotherOrderList');
    Route::post('/manage/anotherOrder', 'OrderController@markOrderHistory');
    Route::get('/manage/orderInfo/{id}','OrderController@getOrderInfo');

    Route::get('/wxnav','WeChatController@navigation');

    Route::get('/idAuth', 'IDAuthController@IDauth');

    Route::post('/session/vcode','SMSController@storeCode');
    Route::post('/vcode/validate','SMSController@checkCode');


    Route::post('/updatePageView/{page}', 'PageViewController@updatePageView');
    Route::get('test',function(){
        return session('dynCode');
    });
});
Route::group(['middleware' => ['web','wechat.oauth']], function () {
    Route::get('/login', 'WeChatController@auth')->name('login');
});


Route::get('/lock/callback', 'LockController@callback');

//Route::get('/sendCode', 'SMSController@sendCode');

Route::group(['prefix' => 'lock'], function(){
    Route::get('updatep_assword', "LockController@apiUpdatePassword");
});
Route::group(['prefix' => 'pay'], function(){
    Route::get('generate_order', "PayController@apitestGenerateOrder");
    Route::get('syncResponse', "PayController@paySyncResponse");
    Route::post('asyncResponse', "PayController@payAsyncResponse");

});




/*


Route::group(['prefix' => 'itopia'], function()
{
    Route::get('/oauth_callback', 'WeChatController@call_back');
    Route::get('/payment/callback', 'WeChatController@payment_call_back');
    Route::get('/server', 'WeChatController@check_server');


    Route::post('/order/create', 'OrderController@storeOrder');
    Route::post('/comment/create', 'CommentController@store');
});

Route::group(['middleware' => 'auth','prefix'=>'itopia'], function (){
    Route::get('/home', 'HomeController@index');
    Route::get('/create/{uid}/{rid}', 'OrderController@createOrder');
    Route::get('/result/{id}','OrderController@getOrderDetail');
    Route::get('/comment/{id}', 'CommentController@create');
    Route::get('/commentResult', 'CommentController@finish');
    Route::get('/orderList/{id}', 'OrderController@getOrderList');

    Route::get('/manage/room', 'RoomController@manageRoom');
    Route::get('/manage/order', 'OrderController@manageOrder');
});
Route::group(['middleware' => ['web','wechat.oauth'],'prefix'=>'itopia'], function () {
    Route::get('/login', 'WeChatController@auth');
});


Route::group(['prefix' => 'itopia'], function()
{
Route::get('/lock/callback', 'LockController@callback');

Route::get('/sendCode', 'SMSController@sendCode');
Route::get('/idAuth', 'IDAuthController@IDauth');
});
Route::group(['prefix' => 'itopia/lock'], function(){
    Route::get('updatePassword', "LockController@apiUpdatePassword");

});

*/