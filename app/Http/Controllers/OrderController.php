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

        if(!empty($order->payNum ))
        {
            $gateDoor = Room::find(Constant::$GATE_ID);
            if(strtotime($gateDoor->updated_at) < Utils::curDay() || empty($gateDoor->passwd ))
            {
                $passwd = Utils::generatePasswd(6);
                $lc = new LockController();
                $ret = $lc->updatePassword(
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
                $gatePasswd = $gateDoor-> passwd;
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
        return "someting error";
    }
    function getOrderList($id)
    {
        PageViewController::updatePageView('orderList');
        return view('order.list')->withOrders(Order::with('hasRoom')->where([
            ['userId','=',$id],
        ['state' ,'>=',Constant::$ORDER_STATE['TOUSE']]
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
            DB::beginTransaction();
            DB::insert('insert into `orders` ' .
                '(`userId`, `roomId`, `startDate`, `startTime`, `endTime`, `duration`, `price`,`isDay`, `state`, `id`, `updated_at`, `created_at`)' .
                'select ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? from users ' .
                'where ((select max(endTime) from orders where `isDay` = 1 and `state` > 3 and `roomId` = ?) is null or '.
                ' (select max(endTime) from orders where `roomId` = ? and `isDay`=1 and `state` > 3) < ? )and id= ?',
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
                    $request->roomId,
                    date('Y-m-d H:i:s', $request->startTime),
                    $request->userId
                ]
            );
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
}
