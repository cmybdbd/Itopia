<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\Order;
use App\Utils\Constant;
use App\Utils\Utils;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PayController extends Controller
{
    //线下
    //private $api_url = 'https://new-beta.wecash.net/paymentKuaijie/payment/quick/payOrder';

    //线上
    private  $api_url = 'https://m.wecash.net/paymentKuaijie/payment/quick/payOrder';
    private $front_url = "http://wjllance.cn/pay/syncResponse";
    private $back_url = "http://wjllance.cn/pay/asyncResponse";

    private $tenanId = "11";
    private $seed = "aec29485267adfef090913c9298f5628";


    public function apitestGenerateOrder()
    {
        $tenantOrder = '6ab5a6fe-2254-11e7-b33b-00163e028974';
        $money = '0.01';
        $userId = '123';
        $userName = 'wjl';
        $idcard = '500227199512173512';
        $productInfo = "test product";
        $phone = '13021941487';
        $ret = $this->generateOrder($tenantOrder, $money, $userId, $userName, $idcard, $productInfo, $phone);

        return Response::json($ret);
     }

    public function generateOrder($tenantOrder, $money, $userId, $userName, $idcard, $productInfo, $phone)
    {
        $query_url = $this->api_url;
        $params = array(
            "tenantId" => $this->tenanId,
            "tenantOrder" => $tenantOrder,
            'signType' => 'MD5',
            'money' => $this->doAES($money),
            'frontUrl' => $this->doAES($this->front_url),
            'backUrl' => $this->doAES($this->back_url),
            'customerId' => $userId,
            'userName' => $userName,
            'idcard' => $this->doAES($idcard),
            'productInfo' => $productInfo,
            'phone' => $phone,
        );
        $sign_arr = array_values($params);
        $sign_arr[] = $this->seed;
        $params['sign'] = Utils::sign($sign_arr);
        $params['deadTime'] = date('Y-m-d H:i:s', time() + 300);

        $res = ApiHandle::httpPostJson($query_url, $params);
        $res = json_decode($res, true);


        if($res['successful'] == 1)
        {
            $orderno = $res['data']['orderno'];
            $order = Order::find($tenantOrder);
            $order->orderno = $orderno;
            $order->save();

            $ret = array(
                'code' => 200,
                'content' => array(
                    'payUrl' => $res['data']['payUrl']
                )
            );
        }
        else
        {
            $ret = array(
                'code' => Constant::$STATUS_CODE['GENERATE_ORDER_FAIL'],
                'content' => $res
            );
        }
        return $ret;
    }

    private function doAES($str)
    {
        return Utils::AES_encrypt($str, $this->seed);
    }

    public function paySyncResponse(Request $request)
    {
        $req = $request->all();

        $oid = $req['tenantOrder'];
        $order = Order::where([
            ['id', '=', $oid],
        ])->first();
        if (!empty($order))
        {
            $order->payNum = json_encode($req);
            if ($req['resultCode'] == 'SUCCESS')
                $order->state = Constant::$ORDER_STATE['TOUSE'];
            $order->save();
        }

        return redirect()->action(
            'OrderController@getOrderDetail', ['id' => $oid]
        );

        /*
        return Response::json($request->all());
        $ret = array(
            'code' => 200,
            'content' => "OK"
        );
        return Response::json($ret);
        */
    }
    public function payAsyncResponse(Request $request)
    {
        $req = $request->all();

        $oid = $req['tenantOrder'];
        $order = Order::where([
            ['id','=',$oid],
        ])->first();
        if(!empty($order))
        {
            if($order->payNum != json_encode($req))
            {
                $order->payNum = json_encode($req);
                if($req['resultCode'] == 'SUCCESS')
                    $order->state = Constant::$ORDER_STATE['TOUSE'];
                $order->save();
            }
        }


        $ret = array(
            "tenantId" => $req['tenantId'],
            "tenantOrder" => $req['tenantOrder'],
            'orderno' => $req['orderno'],
            'serialNo' => $req['serialNo'],
            'payWay' => $req['payWay'],
            'cardNo' => $req['cardNo'],
            'totalFee' => $req['totalFee'],
            'transDate' => $req['transDate'],
            'resultCode' => $req['resultCode'],
            'resultMsg' => $req['resultMsg'],
            'notify' => 'SUCCESS'
        );
        return Response::json($ret);

    }
}
