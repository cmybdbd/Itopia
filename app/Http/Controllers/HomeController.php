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
            ['state', '>=', Constant::$ORDER_STATE['TOUSE']],
                ['state','<', Constant::$ORDER_STATE['HISTORY']]]
        )->first();
        if(!empty($exs))
        {
            return redirect()->action('OrderController@getOrderDetail',['id'=>$exs->id]);
        }
        //return view('map.mapIndex')->withRooms(Room::where('state','<>',0)->get());
        return view('map.mapIndex')->withRooms(Room::where('state','<>',0)->get());
    }

    function dayPage()
    {
        return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function nightPage()
    {
        return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function getDayRooms($name)
    {
        return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function getNightRooms($name)
    {
        return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function orderList()
    {
        $id = Auth::id();
        return redirect()->action('OrderController@getOrderList',['id'=>$id]);
    }

    function mapDisplay()
    {
        PageViewController::updatePageView('home');

        $exs = Order::where([
            ['userId',Auth::id()],
            ['state', '>=', Constant::$ORDER_STATE['TOUSE']],
                ['state','<', Constant::$ORDER_STATE['HISTORY']]]
        )->first();
        //$id = Auth::id();
        return view('map.mapIndex')->withRooms(Room::where('state','<>',0)->get());
    }
}
