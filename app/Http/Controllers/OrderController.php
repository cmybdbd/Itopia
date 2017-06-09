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
        $order = Order::with('hasRoom')->find($id);
        //return view('order.result')->with(['order' => $order, 'gatepass'=>'123456']);
        if(!empty($order->payNum ))
        {
            $room = Room::find($order->roomId);
            //$gateDoor = Room::find(Constant::$GATE_ID);
            $gateDoor = Room::where('state',0)->where('parentId',$room->parentId)->first();
            if(strtotime($gateDoor->updated_at) < Utils::curDay() || empty($gateDoor->passwd ))
            {
                $passwd = Utils::generatePasswd(6);
                $lc = new LockController();
                $ret = $lc->updatePassword(
                    $gateDoor->parentId,
                    '',
                    $passwd,
                    Constant::$REPORT_PHONE,
                    Utils::curDay(),
                    Utils::curDay()+ 24*60*60
                );
                if ($ret['code'] == Constant::$STATUS_CODE['OK'])
                {
                    $gatePasswd = $passwd;
                    $gateDoor->passwd = $passwd;
                    $gateDoor->save();
                }
            }
            else
            {
                $gatePasswd = $gateDoor->passwd;
            }
            if(empty($order->passwd))
            {
                $payNum = json_decode($order->payNum, true);
                if ($payNum['resultCode'] == 'SUCCESS')
                {
                    $strpol = '0123456789';
                    $passwd = '';
                    for ($i = 0; $i < 6; $i++)
                    {
                        $passwd .= $strpol[mt_rand(0, strlen($strpol) - 1)];
                    }
                    $lc = new LockController();
                    $ret = $lc->updatePassword(
                        $gateDoor->parentId,
                        $order->hasRoom->roomLockId,
                        $passwd,
                        Auth::user()->phonenumber,
                        strtotime($order->startTime) - 15*60,
                        strtotime($order->endTime)
                    );
                    //return json_encode($ret);
                    if ($ret['code'] == Constant::$STATUS_CODE['OK'])
                    {
                        $order->passwd = $passwd;
                        $order->save();
                    }
                }
            }
            if(!empty($order->passwd))
            {
                return view('order.result')->with(['order' => $order, 'gatepass'=>$gatePasswd]);
            }
        }
        return "something error";
    }
    function getOrderList($id)
    {
        PageViewController::updatePageView('orderList');
        $orders =Order::with('hasRoom')->where([['userId','=',$id],
            ['state' ,'>=',Constant::$ORDER_STATE['COMPLETE']]
            ])->get();
        $orders= $this->arrayOrderSort($orders);
        //return $orders;
        //return view('order.list')->withOrders($orders);
        return view('order.list')->withOrders(Order::with('hasRoom')->where([
            ['userId','=',$id],
        ['state' ,'>=',Constant::$ORDER_STATE['COMPLETE']]
        ])->orderBy('endTime','DESC')->get());
    }
    function manageOrder()
    {
        return view('manage.order')->with(
            [

                'orders' => Order::where(
                        'state', '>=', Constant::$ORDER_STATE['COMPLETE']
                    )->orderBy('startTime','asc')->get(),
                'rooms' => Room::where('state','<>',0)->get()]);
    }
    function getAnotherOrderList()
    {
        Order::where([
            ['state','<=',Constant::$ORDER_STATE['USING']],
            ['state','>=',Constant::$ORDER_STATE['TOUSE']],
            ['endTime', '<=', date('Y-m-d H:i:s', time())]
        ])->update(['state'=>Constant::$ORDER_STATE['COMPLETE']]);
        return view('manage.anotherOrder')->with(
            [
                'orders' => Order::where(
                    [
                        ['state', '>=', Constant::$ORDER_STATE['COMPLETE']],
                        ['payNum', '<>', ''],
                        ['endTime', '<=', date('Y-m-d 23:30:00', time())],
                        ['endTime', '>=', date('Y-m-d 00:00:00', time())]
                        ]
                )->orderBy('state', 'asc')->orderBy('endTime', 'asc')-> get()
            ]
        );
    }
    /*
     * show
     */
    function test()
    {
        $rid = 'ae50f8da-225e-11e7-b33b-00163e028924';
        /*
        $rid = 'ae50f8da-225e-11e7-a09c-03163e028801';
        $night = Order::where([
            ['isDay' , '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
            ['state', "<", Constant::$ORDER_STATE['HISTORY']]
        ])->where('startTime','>=',date('Y-m-d 00:00:00', time()+24*60*60*0) )->where('startTime','<=',date('Y-m-d 23:30:00', time()+24*60*60*0) )->max('startTime');
        if(empty($night))
            return 0;
        else
            return 1;

        $night = Order::where([
            ['roomId','=', $rid],
            ['isDay' , '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
            ['state', "<", Constant::$ORDER_STATE['HISTORY']]
        ])->where('startTime','>=',date('Y-m-d 00:00:00', time()+24*60*60*0) )->where('startTime','<=',date('Y-m-d 23:00:00', time()+24*60*60*0) )->max('startTime');
        if(empty($night))
            return date('Y-m-d 00:00:00', time()+24*60*60*0);
        else
            return $night;*/
        $day = 0;
        $maxDayTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 1],
            ['state', '>=', Constant::$ORDER_STATE['UNPAY']]
        ])->where('endTime','<',date("Y-m-d",time()+86400*($day+1)))->where('endTime','>',date("Y-m-d",time()+86400*($day)))->max('endTime'));
        $maxNightTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['UNPAY']]
        ])->where('endTime','<',date("Y-m-d",time()+86400*(0 + 1)))->max('endTime'));
        //$nowday = time();
        //return $maxDayTime;
        $day = 1;
        if(!empty($maxDayTime) && $maxDayTime > time())
        {
            $dayTime = $maxDayTime;
        }
        else
        {
            if($day == 0)
                $dayTime = strtotime(date("Y-m-d H:i:s",time()));
            else
                $dayTime = 0;
        }
        if(!empty($maxNightTime))
        {
            $nightTime = $maxNightTime;
        }
        else
        {
            $nightTime = 0;
        }
        $maxDayTime = date("Y-m-d H:i:s",$dayTime);
        $maxNightTime = date("Y-m-d H:i:s",$nightTime);
        return $maxDayTime;
    }
    function createDayOrder($uid, $rid, $day)
    {
        $maxDayTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 1],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']]
        ])->where('endTime','<',date("Y-m-d",time()+86400*($day + 1)))->where('endTime','>',date("Y-m-d",time()+86400*($day)))->max('endTime'));
        $maxNightTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']]
        ])->where('endTime','<',date("Y-m-d",time()+86400*($day + 1)))->where('endTime','>',date("Y-m-d",time()+86400*($day)))->max('endTime'));
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
            if($day == 0)
                $dayTime = strtotime(date("Y-m-d H:i:s",time()));
            else
                $dayTime = 0;
        }
        if(!empty($maxNightTime))
        {
            $nightTime = $maxNightTime;
        }
        else
        {
            $nightTime = 0;
        }
        PageViewController::updatePageView('create');
        return view('order.create')->with([
            'room'=>Room::find($rid),
            'startDayTime'=>$dayTime,
            'startNightTime' =>$nightTime,
            'olderOrder'=>$existOrder,
            'dayCount'=>$day]);
    }
    function createNightOrder($uid, $rid ,$day)
    {
        $maxDayTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 1],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']]
        ])->where('endTime','<',date("Y-m-d",time()+86400*($day + 1)))->max('endTime'));
        $maxNightTime = strtotime(Order::where([
            ['roomId','=', $rid],
            ['isDay', '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']]
        ])->where('startTime','<',date("Y-m-d",time()+86400*($day + 1)))->where('startTime','>',date("Y-m-d",time()+86400*$day))->max('startTime'));
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
            $dayTime = time()+86400*$day;
        }
        if(!empty($maxNightTime))
        {
            $nightTime = $maxNightTime;
        }
        else
        {
            $nightTime = 0;
        }
        PageViewController::updatePageView('create');
        return view('order.createNight')->with([
            'room'=>Room::find($rid),
            'startDayTime'=>$dayTime,
            'startNightTime' =>$nightTime,
            'olderOrder'=>$existOrder,
            'dayCount'=>$day]);
    }
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
            $nightTime = $maxNightTime + 24*60*60*1000;
        }
        else
        {
            $nightTime = Utils::curNight();
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
            Order::where([['id', $request->uuid],['isDay',$request->isDay]])->update(['state' => Constant::$ORDER_STATE['REMOVE']]);
        }
        $order = Uuid::generate()->string;
        if($request->isDay)
        {
            $maxDayTime = strtotime(Order::where([
                ['roomId','=', $request->roomId],
                ['isDay', '=', 1],
                ['state', '>=', Constant::$ORDER_STATE['COMPLETE']]
            ])->where('endTime','<',date("Y-m-d",$request->startTime+24*60*60))->max('endTime'));
            if(!empty($maxDayTime))
                if($maxDayTime > strtotime(date('Y-m-d H:i:s', $request->startTime)))
                    return Response::json(['code' => '300','param' => 'DB']);
            DB::beginTransaction();
            DB::insert('insert into `orders` ' .
                '(`userId`, `roomId`, `startDate`, `startTime`, `endTime`, `duration`, `price`,`isDay`, `state`, `id`, `updated_at`, `created_at`)' .
                'select ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? from users where id = ?' ,//.
                //'where ((select max(endTime) from orders where `isDay` = 1 and `state` > 3 and `roomId` = ?) is null or '.
                //' (select max(endTime) from orders where `roomId` = ? and `isDay`=1 and `state` > 3) < ? ) and id= ?',
                [
                    $request->userId,
                    $request->roomId,
                    date('Y-m-d H:i:s', $request->date),
                    date('Y-m-d H:i:s', $request->startTime),
                    date('Y-m-d H:i:s', $request->endTime),
                    $request->duration,
                    $request->price,
                    $request->isDay ? 1 : 0,
                    Constant::$ORDER_STATE['UNPAY'],
                    $order,
                    date('Y-m-d H:i:s', time()),
                    date('Y-m-d H:i:s', time()),
                    //$request->roomId,
                    //$request->roomId,
                    //date('Y-m-d', $request->startTime + 24*60*60),// new add
                    //date('Y-m-d', $request->startTime + 24*60*60),// new add
                    //date('Y-m-d H:i:s', $request->startTime),
                    $request->userId
                ]
            );
            //return Response::json(['code' => '300', 'param' => 'isday']);
            DB::commit();

        }
        else
        {
            DB::beginTransaction();
            DB::insert('insert into `orders` ' .
                '(`userId`, `roomId`, `startDate`, `startTime`, `endTime`, `duration`, `price`,`isDay`, `state`, `id`, `updated_at`, `created_at`)' .
                'select ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? from users ' .
                'where (select id from orders where `state` > 3 and `isDay`=0 and `roomId` = ? and `startDate` = ?) is null and id= ?',
                [
                    $request->userId,
                    $request->roomId,
                    date('Y-m-d H:i:s', $request->date),
                    date('Y-m-d H:i:s', $request->startTime),
                    date('Y-m-d H:i:s', $request->endTime),
                    $request->duration,
                    $request->price,
                    $request->isDay ? 1 : 0,
                    Constant::$ORDER_STATE['UNPAY'],
                    $order,
                    date('Y-m-d H:i:s', time()),
                    date('Y-m-d H:i:s', time()),

                    $request->roomId,
                    date('Y-m-d H:i:s', $request->date),

                    $request->userId
                ]
            );
            DB::commit();
        }
        $user =User::find($request->userId);
        $succ = Order::find($order);

        $json = '';

        if (!empty($succ))
        {
            $pay =new PayController();
            $json = $pay->generateOrder($order,
                $request->price,
                $user->id,
                $user->name,
                $user->idnumber,
                'info',
                $user->phonenumber
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
    function restoreOrder(Request $request)
    {
        $this->validate($request, [
            'orderId' => 'required',
            'userId' => 'required',
            'roomId' => 'required',
            'date' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'isDay'  => 'required'
        ]);

        $order = $request->orderId;
        
        $user =User::find($request->userId);
        $succ = Order::find($order);

        $json = '';

        if (!empty($succ))
        {
            $pay =new PayController();
            $json = $pay->generateOrder($order,
                $request->price,
                $user->id,
                $user->name,
                $user->idnumber,
                'info',
                $user->phonenumber
            );
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
    function completeOrder(Request $request)
    {
        $this->validate($request,[
            'oid' => 'required'
        ]);
        $oid = $request->oid;
        Order::find($oid)->update(['state'=> Constant::$ORDER_STATE['COMPLETE']]);
    }
    function markOrderHistory(Request $request)
    {
        $this->validate($request,[
            'oid' => 'required'
        ]);
        $oid = $request->oid;
        Order::find($oid)->update(['state'=> Constant::$ORDER_STATE['HISTORY']]);
    }
    function getOrderInfo($id)
    {
        $order = Order::with('hasRoom')->find($id);
        return $order;
    }

    function arrayOrderSort($orders)
    {
        $array_orders = array();
        $i = 0;
        foreach($orders as $key => $order)
        {
            $array_orders[$i] = $order;
            $i++;
        }
        $number = $i;
        for($i = 0;$i< $number;$i++)
        {
            for($j= 0;$j < $number -$i -1; $j++)
            {
                $tmp1 = $array_orders[$j];
                $tmp2 = $array_orders[$j+1];
                $rank1 = 0;
                $rank2 = 0;
                switch($tmp1->state)
                {
                    case 10:
                        $rank1 = 4;
                        break;
                    case 5:
                        $rank1 = 1;
                        break;
                    case 4:
                        $rank1 = 2;
                        break;
                    case 3:
                        $rank1 = 3;
                        break;
                    default:
                        $rank1 = 5;
                }
                switch($tmp2->state)
                {
                    case 10:
                        $rank2 = 4;
                        break;
                    case 5:
                        $rank2 = 1;
                        break;
                    case 4:
                        $rank2 = 2;
                        break;
                    case 3:
                        $rank2 = 3;
                        break;
                    default:
                        $rank2 = 5;
                }
                $time1 = $tmp1->endTime;
                $time2 = $tmp2->endTime;
                if($rank1 > $rank2)
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
                    continue;
                }
                else if(($rank1 == $rank2)&&($time1 < $time2))
                {
                    $array_rooms[$j] = $tmp2;
                    $array_rooms[$j+1] = $tmp1;
                    continue;
                }
                
            }
        }
        return $array_orders;
    }
}
