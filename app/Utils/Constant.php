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


    public static $ORDER_STATE = array(
        'REMOVE'   => 0,
        'FAILED'   => 1,
        'UNPAY'    => 2,
        'TOUSE'    => 3,
        'USING'    => 4,
        'USED'     => 5,
        'COMPLETE' => 6,
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