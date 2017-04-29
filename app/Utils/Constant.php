<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/9/17
 * Time: 6:00 PM
 */
namespace App\Utils;
define('DOMAIN', 'wjllance.cn');
define('URL', 'http://www.wjllance.cn');

class Constant
{

    public static $DOMAIN=URL;


    public static $HOME_URL=URL."/home";
    public static $LOGIN_URL=URL."/login";
    public static $REPORT_PHONE=13161953877;
    public static $STATUS_CODE = array(
        "OK" => 200,
        "PARAMS_MISS" => 400,
        "FAIL_ADD_PASSWORD" => 401,
        "FAIL_UPDATE_PASSWORD" => 402,
        "GENERATE_ORDER_FAIL" => 403
    );
    public static $PAY_SEED = 'aec29485267adfef090913c9298f5628';

    public static $GATE_ID = 'aa50f8da-0000-11e7-b33b-000000000000';
    public static $ORDER_STATE = array(
        'REMOVE'   => 0,
        'FAILED'   => 1,
        'COMPLETE' => 3,
        'UNPAY'    => 4,
        'TOUSE'    => 5,
        'USING'    => 6,

        'HISTORY'  => 10,

    );
    public static $WECHAT_PARAM = array(
        'APPID'  => '111111111',
        'MCH_ID' => '111111111',
        'KEY' => 'keykeykey',
        'EXPIRE_TIME' => 300,
        'TRADE_TYPE' => 'JSAPI',
        'UNIFIEDORDER_URL' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
        'CALLBACK_URL' => 'payment/callback',
    );
}