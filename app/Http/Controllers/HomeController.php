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
        )->get();

        if(!empty($exs))
        {
            foreach($exs as $ex_order)
            {
                if($ex_order->endTime < date("Y-m-d H:i:s",time()))
                {
                    Order::find($ex_order->id)->where('endTime','<',date("Y-m-d H:i:s",time()))->update(['state'=> Constant::$ORDER_STATE['COMPLETE']]);
                }
            }
            //return redirect()->action('OrderController@getOrderDetail',['id'=>$exs->id]);
        }
        
        return view('map.mapIndex')->withRooms(Room::where('state','<>',0)->get());
    }

    function dayPage()
    {
        $rooms = Room::where('state','<>',0)->get();
        $rooms = $this->arrayDaySort($rooms,0);
        return view('list.dayRoom')->withRooms($rooms);
        //return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function nightPage()
    {
        $rooms = Room::where('state','<>',0)->get();
        $rooms = $this->arrayNightSort($rooms,0);
        return view('list.nightRoom')->withRooms($rooms);
        //return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function getDayRooms($name)
    {
        $rooms = Room::where('state','<>',0)->Where('parentId',$name)->get();
        $rooms = $this->arrayDaySort($rooms,0);
        return view('list.dayRoom')->withRooms($rooms);
        //return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function getNightRooms($name)
    {
        $rooms = Room::where('state','<>',0)->Where('parentId',$name)->get();
        $rooms = $this->arrayNightSort($rooms,0);
        return view('list.nightRoom')->withRooms($rooms);
        //return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function orderList()
    {
        $id = Auth::id();
        return redirect()->action('OrderController@getOrderList',['id'=>$id]);
    }
    function my_sort($a,$b)
    {
        $time1 = $a->nextTime();
        $time2 = $b->nextTime();
        if($time1 == $time2 || $time2 == 0)
            return 0;
        return 1;

    }
    function arrayDaySort($rooms,$day)
    {
        $array_rooms = array();
        $i = 0;
        foreach($rooms as $key => $room)
        {
            $array_rooms[$i] = $room;
            $i++;
        }
        $number = $i;
        for($i = 0;$i< $number;$i++)
        {
            for($j=$i+1;$j < $number; $j++)
            {
                $tmp1 = $array_rooms[$i];
                $tmp2 = $array_rooms[$j];
                $time1 = 0;
                $time2 = 0;
                if($day == 0)
                {
                    $time1 = $tmp1->nextUsingTime();
                    $time2 = $tmp2->nextUsingTime();
                }
                else
                {
                    $time1 = $tmp1->nextDayUsingTime();
                    $time2 = $tmp2->nextDayUsingTime();
                }
                if($time1 == $time2)
                {
                    if($time1 == 0)
                        if($tmp1->state > $tmp2->state)
                        {
                            $array_rooms[$i] = $tmp2;
                            $array_rooms[$j] = $tmp1;
                            continue;
                        }
                }
                if($time1 == -1)
                {
                    $array_rooms[$i] = $tmp2;
                    $array_rooms[$j] = $tmp1;
                    continue;
                }
                if($time1 > $time2 && $time2 != -1)
                {
                    $array_rooms[$i] = $tmp2;
                    $array_rooms[$j] = $tmp1;
                    continue;
                }
                
            }
        }
        return $array_rooms;
    }
    function arrayNightSort($rooms,$day)
    {
        $array_rooms = array();
        $i = 0;
        foreach($rooms as $key => $room)
        {
            $array_rooms[$i] = $room;
            $i++;
        }
        $number = $i;
        for($i = 0;$i< $number;$i++)
        {
            for($j=$i+1;$j < $number; $j++)
            {
                $tmp1 = $array_rooms[$i];
                $tmp2 = $array_rooms[$j];
                $time1 = $tmp1->isNightBooked($day);
                $time2 = $tmp2->isNightBooked($day);
                if(!($time1 == $time2 || $time2 > $time1))
                {
                    $array_rooms[$i] = $tmp2;
                    $array_rooms[$j] = $tmp1;
                }
            }
        }
        return $array_rooms;
    }
}
