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
        PageViewController::updatePageView('useHour');
        $rooms = Room::where('state','<>',0)->orderBy('state','ASC')->get();
        $rooms = $this->arrayDaySort($rooms,0);
        return view('list.dayRoom')->withRooms($rooms);
        //return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function nightPage()
    {
        PageViewController::updatePageView('useNight');
        $rooms = Room::where('state','<>',0)->orderBy('state','ASC')->get();
        $rooms = $this->arrayNightSort($rooms,0);
        return view('list.nightRoom')->withRooms($rooms);
        //return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function dayPageLocation(Request $request)
    {
        $this->validate($request, [
            'lo' => 'required',
            'la' => 'required',
        ]);
        $rooms = Room::where('state','<>',0)->orderBy('state','ASC')->get();
        $rooms = $this->arrayDaySort($rooms,0);
        $rooms = $this->arrayLocationSort($rooms,$request->lo,$request->la);
        return view('list.dayRoom')->withRooms($rooms);
        //return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function nightPageLocation(Request $request)
    {
        $this->validate($request, [
            'lo' => 'required',
            'la' => 'required',
        ]);
        $rooms = Room::where('state','<>',0)->orderBy('state','ASC')->get();
        $rooms = $this->arrayNightSort($rooms,0);
        $rooms = $this->arrayLocationSort($rooms,$request->lo,$request->la);
        return view('list.nightRoom')->withRooms($rooms);
        //return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->get());
    }
    function getDayRooms($name)
    {
        $rooms = Room::where('state','<>',0)->Where('parentId',$name)->orderBy('state','ASC')->get();
        $rooms = $this->arrayDaySort($rooms,0);
        return view('list.dayRoom')->withRooms($rooms);
        //return view('list.dayRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function getNightRooms($name)
    {
        $rooms = Room::where('state','<>',0)->Where('parentId',$name)->orderBy('state','ASC')->get();
        $rooms = $this->arrayNightSort($rooms,0);
        return view('list.nightRoom')->withRooms($rooms);
        //return view('list.nightRoom')->withRooms(Room::where('state','<>',0)->Where('parentId',$name)->get());
    }
    function orderList()
    {
        $id = Auth::id();
        return redirect()->action('OrderController@getOrderList',['id'=>$id]);
    }
    function getOrderByDay($rid,$day)
    {
        $room = Room::where('id','=',$rid)->get();
        $order = 0;
        //return date('Y-m-d', time()+$day*24*60*60);
        if(empty($room))
            $order = Order::where('state','>=',3)->Where('state','<=',5)->Where('state','<>',4)->where('startTime', '<=', date('Y-m-d', $day + 24*60*60))->where('startTime', '>', date('Y-m-d', $day))->get();
        else
            $order = Order::where('state','>=',3)->Where('state','<=',5)->Where('state','<>',4)->where('startTime', '<=', date('Y-m-d', $day + 24*60*60))->where('startTime', '>', date('Y-m-d', $day))->where('roomId','=',$rid)->get();
        return $order;
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
            for($j= 0;$j < $number -$i -1; $j++)
            {
                $tmp1 = $array_rooms[$j];
                $tmp2 = $array_rooms[$j+1];
                $time1 = 0;
                $time2 = 0;
                if($day == 0)
                {
                    $time1 = $tmp1->today_nextTime();
                    $time2 = $tmp2->today_nextTime();
                }
                else
                {
                    $time1 = $tmp1->next_day_time();
                    $time2 = $tmp2->next_day_time();
                }

                if($time1 == -1 && $time2 != -1)
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
                    continue;
                }
                if($time1 > $time2 && $time2 != -1)
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
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
            for($j= 0;$j < $number -$i -1; $j++)
            {
                $tmp1 = $array_rooms[$j];
                $tmp2 = $array_rooms[$j+1];
                $time1 = $tmp1->isNightBooked($day);
                $time2 = $tmp2->isNightBooked($day);
                if(!($time1 == $time2 || $time2 > $time1))
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
                }
            }
        }
        return $array_rooms;
    }

    function arrayLocationSort($rooms,$lo,$la)
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
            for($j= 0;$j < $number -$i -1; $j++)
            {
                $tmp1 = $array_rooms[$j];
                $tmp2 = $array_rooms[$j+1];
                $lenth_11 = 0.76*111*abs($tmp1->longitude - $lo) * 0.76*111*abs($tmp1->longitude - $lo);
                $lenth_12 = 111*abs($tmp1->latitude - $la) * 111*abs($tmp1->latitude - $la);
                $lenth_21 = 0.76*111*abs($tmp2->longitude - $lo) * 0.76*111*abs($tmp2->longitude - $lo);
                $lenth_22 = 111*abs($tmp2->latitude - $la) * 111*abs($tmp2->latitude - $la);
                $lenth1 = $lenth_11 + $lenth_12;
                $lenth2 = $lenth_21 + $lenth_22;

                if($lenth1 > $lenth2)
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
                    continue;
                }
                
            }
        }
        return $array_rooms;
    }
}
