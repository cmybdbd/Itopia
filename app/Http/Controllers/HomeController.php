<?php

namespace App\Http\Controllers;

use App\Order;
use App\Room;
use App\User;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    function index(){
        PageViewController::updatePageView('home');

        $exs = Order::where([
            ['userId',Auth::id()],
            ['state', '>=', Constant::$ORDER_STATE['TOUSE']]]
        )->first();
        if(!empty($exs))
        {
            return redirect()->action('OrderController@getOrderDetail',['id'=>$exs->id]);
        }
        return view('frontpage')->withRooms(Room::where('state','<>',0)->get());

    }
}
