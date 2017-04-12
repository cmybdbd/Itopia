<?php

namespace App\Http\Controllers;

use Constant;
use Illuminate\Http\Response;
use Utils;
use App\Order;
use App\Room;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function getOrderDetail($id)
    {
        return view('order.result');
    }
    function getOrderList()
    {

    }
    /*
     * show
     */
    function createOrder($id)
    {
        return view('order.create')->withRoom(Room::find($id));
    }
    /*
     * create
     */
    function storeOrder(Request $request)
    {
        $this->validate($request, [
            'userId'    => 'required',
            'roomId'    => 'required',
            'date'      => 'required',
            'startTime' => 'required',
            'endTime'   => 'required',
            'duration'  => 'required',
            'payNum'    => 'required',
        ]);

        $order = new Order();
        $order->userId = $request->userId;
        $order->roomId =$request->roomId;
        $order->date =$request->date;
        $order->startTime =$request->startTime; 
        $order->endTime =$request->endTime;
        $order->duration =$request->duration;
        $order->payNum = $request->payNum;

        $existOrder = Order::where([
            ['userId', '=', $order->userId],
            ['roomId', '=', $order->roomId],
            ['state',  '=', Constant::$ORDER_STATE['UNPAY']],
        ])->first();
        if($existOrder->count())
        {
            $order = $existOrder;
        }
        else
        {
            $order->state = Constant::$ORDER_STATE['UNPAY'];
            $order->save();
        }
        $param = $this->getWeChatPayParam([
            'body' => 'Itopia',
            'out_trade_no' => $order->id,
            'total_fee' => $order->payNum
        ]);
        if(is_array($param))
        {
            return Response::json(['code' => '200', 'param' =>$param]);
        }
        else
        {
            return Response::json(['code' => '300']);
        }
    }
    function cancelOrder()
    {}
    function completeOrder()
    {}


    private function getWeChatPayParam($p)
    {
        date_default_timezone_set('PRC');
        $orderStartTime = time();
        $order = array(
            // need sort
            "appid" => Constant::$WECHAT_PARAM['APPID'],
            "body" => $p['body'],
            "mch_id" => Constant::$WECHAT_PARAM['MCH_ID'],
            "nonce_str" => md5(time() . mt_rand(0, 1000)),
            "notify_url" => url(Constant::$WECHAT_PARAM['CALLBACK_URL']),
            "out_trade_no" => $p['out_trade_no'],
            "spbill_create_ip" => Utils::get_server_ip(),
            "time_expire" => date("YmdHis", $orderStartTime + Constant::$WECHAT_PARAM['EXPIRE_TIME']),
            "time_start"  => date("YmdHis", $orderStartTime),
            "total_fee" => $p['total_fee'],
            "trade_type" => Constant::$WECHAT_PARAM['TRADE_TYPE']
        );
        $stringA = Utils::my_buid_query($order);
        $stringSignTemp = $stringA .'&key='. Constant::$WECHAT_PARAM['KEY'];
        $sign = strtoupper(md5($stringSignTemp));

        $order['sign'] = $sign;
        $xml = Utils::createxml($order);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Constant::$WECHAT_PARAM['UNIFIEDORDER_URL']);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "xmlRequest=" . $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);

        //convert the XML result into array
        $array_data = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($array_data->return_code != "SUCCESS" || $array_data->result_code != "SUCCESS")
        {
            //return $array_data;
            //ResponseHelper::sendPositive(array('fail' => 'true','data' =>$array_data));
            return $array_data->result_code;
        }

        $response = array(
            "appid" => $order['appid'],
            "noncestr" => $order['nonce_str'],
            "package" => 'prepay_id=' . $array_data->prepay_id,
            "signType" => "MD5",
            "timestamp" => '' . time()
        );

        $stringA = Utils::my_buid_query($response);
        $stringSignTemp = $stringA . '&key='. Swoole::$php->constant['wechatpay_config']['key'];

        $sign = strtoupper(md5($stringSignTemp));
        $response['sign'] = $sign;
        //$ret_data = Utils::my_buid_query($response);
        //ResponseHelper::sendPositive($ret_data);
        return $response;

    }


}
