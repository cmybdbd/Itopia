<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\Order;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PayController extends Controller
{
    //线下
    private $api_url = 'https://new-beta.wecash.net/paymentKuaijie/payment/quick/payOrder';
    private $front_url = "";
    private $back_url = "";

    private $tenanId = "11";
    private $seed = "aec29485267adfef090913c9298f5628";

    public function generateOrder($tenantOrder, $money, $userId, $userName, $idcard, $productInfo, $phone)
    {
        $query_url = $this->api_url;
        $params = array(
            "tenantId" => $this->tenanId,
            "tenantOrder" => $tenantOrder,
            'signType' => 'MD5',
            'money' => doAES($money),
            'frontUrl' => $this->doAES($this->front_url),
            'backUrl' => $this->doAES($this->back_url),
            'customerId' => $userId,
            'userNmae' => $userName,
            'idcard' => $idcard,
            'productInfo' => $productInfo,
            'phone' => $phone,
        );
        $sign = getSignature($params);
        $params['sign'] = $sign;

        $res = ApiHandle::httpPostJson($query_url, $params);
        $res = json_decode($res, true);
        var_dump($res);
        if($res['resultCode'] == '000')
        {
            $orderno = $res['orderno'];
            $order = Order::find($tenantOrder);
            $order->orderno = $orderno;
            $order->save();
            //...

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

    public static function doAES($str)
    {
        return exec('java -jar ../java/AESUtils.jar e '.Constant::$PAY_SEED. ' '. $str);
    }
}
