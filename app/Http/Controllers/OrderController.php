<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Utils\Utils;
use App\Order;
use App\Room;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class OrderController extends Controller
{
    function getOrderDetail($id)
    {
        PageViewController::updatePageView('result');
        return view('order.result')->withOrders(Order::with('hasRoom')->where('id','=',$id)->first());
    }
    function getOrderList($id)
    {
        PageViewController::updatePageView('orderList');
        return view('order.list')->withOrders(Order::with('hasRoom')->where([
            ['userId','=',$id],
        ['state' ,'>',Constant::$ORDER_STATE['UNPAY']]
        ])->get());
    }
    function manageOrder()
    {
        return view('manage.order')->withOrders(Order::with('hasRoom')
            ->with('hasUser')
        ->where([
            ['state', '>', 2],
        ])->get());
    }
    /*
     * show
     */
    function createOrder($uid, $rid)
    {
        $maxDayTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 1],
            ['state', '>', Constant::$ORDER_STATE['REMOVE']]
        ])->max('endTime'));
        $maxNightTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 0],
            ['state', '>', Constant::$ORDER_STATE['REMOVE']]
        ])->max('endTime'));
        $existOrder = Order::where([
            ['userId' , '=', $uid],
            ['roomId', '=', $rid],
            ['isDay', '=', 1],
            ['state' ,'=', Constant::$ORDER_STATE['UNPAY']]
        ])->first();
        if(!empty($maxDayTime) && $maxDayTime > time())
        {
            $dayTime = $maxDayTime;
        }
        else
        {
            $dayTime = time();
        }
        if(!empty($maxNightTime))
        {
            $nightTime = $maxNightTime;
        }
        else
        {
            $nightTime = time();
        }
        PageViewController::updatePageView('create');
        return view('order.create')->with([
            'room'=>Room::find($rid),
            'startDayTime'=>$dayTime,
            'startNightTime' =>$nightTime,
            'olderOrder'=>$existOrder]);
    }
    /*
     * create
     */
    function storeOrder(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'roomId' => 'required',
            'date' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'isDay'  => 'required'
        ]);

        if (isset($request->uuid))
        {
            Order::where('id', $request->uuid)->update(['state' => Constant::$ORDER_STATE['REMOVE']]);
        }
        $order = Uuid::generate()->string;
        DB::beginTransaction();
        DB::insert('insert into `orders` '.
            '(`userId`, `roomId`, `startDate`, `startTime`, `endTime`, `duration`, `price`,`isDay`, `state`, `id`, `updated_at`, `created_at`)' .
            'select ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? from users '.
            'where ((select max(endTime) from orders where `state` > 0) is null or (select max(endTime) from orders where `roomId` = ? and `state` > 0) < ? )and id= ?',
            [
                $request->userId,
                $request->roomId,
                date('Y-m-d H:i:s', $request->date),
                date('Y-m-d H:i:s', $request->startTime),
                date('Y-m-d H:i:s', $request->endTime),
                $request->duration,
                $request->price,
                $request->isDay ? 1: 0,
                Constant::$ORDER_STATE['UNPAY'],
                $order,
                date('Y-m-d H:i:s', time()),
                date('Y-m-d H:i:s', time()),
                $request->roomId,
                date('Y-m-d H:i:s', $request->startTime),
                $request->userId
            ]
        );
        DB::commit();
        $user =User::find($request->userId);
        $succ = Order::find($order);

        /*
                $order = new Order();
                $order->userId = $request->userId;
                $order->roomId =$request->roomId;
                $order->date =  date('Y-m-d H:i:s',$request->date);
                $order->startTime =  date('Y-m-d H:i:s',$request->startTime);
                $order->endTime =  date('Y-m-d H:i:s',$request->endTime);
                $order->duration =$request->duration;
                $order->payNum = $request->payNum;

                $existOrder = Order::where([
                    ['userId', '=', $order->userId],
                    ['roomId', '=', $order->roomId],
                    ['state',  '=', Constant::$ORDER_STATE['UNPAY']],
                ])->first();
                if(!empty($existOrder))
                {
                    $order = $existOrder;
                }
                else
                {
                    $order->state = Constant::$ORDER_STATE['UNPAY'];
                    $order->save();
                }
        */
        $json = '';

        if (!empty($succ))
        {
            $pay =new PayController();
            $json = $pay->generateOrder($order,
                '0.01',
                $user->id,
                'tyq',
                '362323199504260013',
                'info',
                '18811792605'
            );
           // $json = json_decode($json,true);
        }

        if (is_array($json))
        {
            return Response::json(['code' => '200', 'param' => $json]);
        } else
        {
            return Response::json(['code' => '300']);
        }
    }
    function cancelOrder()
    {}
    function completeOrder()
    {}
}
