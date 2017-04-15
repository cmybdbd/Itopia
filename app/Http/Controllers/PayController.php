<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $sign = getsig();

        $money_aes = doAES($money);

        $params = array(
            "tenantId" => $this->tenanId,
            "tenantOrder" => $tenantOrder,
            'signType' => 'MD5',
            'frontUrl' => $this->front_url,
            'backUrl' => $this->back_url,
            'customerId' => $userId,
            'userNmae' => $userName,
            'idcard' => $idcard,
            'productInfo' => $productInfo,
            'phone' => $phone,
            'money' => $money_aes
        );


}
