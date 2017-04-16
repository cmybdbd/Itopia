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
    private $api_url = 'https://new-beta.wecash.net/paymentKuaijie/payment/quick/payOrder';
    private $front_url = "http://wjllance.cn/pay/syncResponse";
    private $back_url = "http://wjllance.cn/pay/asyncResponse";

    private $tenanId = "11";
    private $seed = "aec29485267adfef090913c9298f5628";


    public function apitestGenerateOrder()
    {
        $tenantOrder = '123456789';
        $money = '0.01';
        $userId = '123';
        $userName = 'wjl';
        $idcard = '500227199512173512';
        $productInfo = "test product";
        $phone = '13021941487';
        $this->generateOrder($tenantOrder, $money, $userId, $userName, $idcard, $productInfo, $phone);
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
            'userNmae' => $userName,
            'idcard' => $idcard,
            'productInfo' => $productInfo,
            'phone' => $phone,
        );
        $sign_arr = array_values($params);
        $sign_arr[] = $this->seed;
        $params['sign'] = Utils::sign($sign_arr);

        $res = ApiHandle::httpPostJson($query_url, $params);
        $res = json_decode($res, true);

        var_dump($res);


        if($res['resultCode'] == '000')
        {
            $orderno = $res['orderno'];
            $order = Order::find($tenantOrder);
            $order->orderno = $orderno;
            $order->save();

            $ret = array(
                'code' => 200,
                'content' => array(
                    'payUrl' => $res['payUrl']
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
        return Response::json($ret);
    }

    private function doAES($str)
    {
        return Utils::AES_encrypt($str, $this->seed);
    }

    public function paySyncResponse()
    {
        $ret = array(
            'code' => 200,
            'content' => "OK"
        );
        return Response::json($ret);
    }
    public function payAsyncResponse()
    {
        $ret = array(
            "tenantId" => $_POST['tenantId'],
            "tenantOrder" => $_POST['tenantOrder'],
            'orderno' => $_POST['orderno'],
            'serialNo' => $_POST['serialNo'],
            'payWay' => $_POST['payWay'],
            'cardNo' => $_POST['cardNo'],
            'totalFee' => $_POST['totalFee'],
            'transDate' => $_POST['transDate'],
            'resultCode' => $_POST['resultCode'],
            'resultMsg' => $_POST['resultMsg'],
            'notify' => $_POST['SUCCESS']
        );
        return Response::json($ret);

    }
}
