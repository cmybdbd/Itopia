<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SMSController extends Controller
{
    //

    private $accountNo = 'rent2';
    private $pwd = 'bcv86vcs9ip11m';

    private $smsUrl = 'http://sms.wecash.net/sms-platform/sms/sendSMSCode';

    public function sendCode()
    {
        $mblNo = $_GET['phonenumber'];
        $templateNo = 'RNT002';
        $repVar = '8807';
        $ret = array(
            'code' => "501",
            "content" => "发送失败，请重试"
        );
        $res = $this->sendMessage($templateNo, $repVar, $mblNo);
        if($res)
        {
            $res = json_decode($res, true);
            if($res['success'])
            {
                $ret = array(
                    "code" => 200,
                    "content" => "发送成功"
                );
            }
        }
        return Response::json($ret);
    }

    public function checkCode()
    {
        session_start();
        $ret = array();
        if(isset($_SESSION["dynCode"]))
        {
            if($_GET['dynCode'] == $_SESSION['dynCode'])
            {
//  save phonenumber
                $ret = array(
                    "code" => 200,
                    "content" => "验证通过"
                );
            }
            else
            {
                $ret = array(
                    "code" => 504,
                    "content" => "验证码错误"
                );
            }
        }
        else
        {
            $ret = array(
                "code" => 503,
                "content" => "服务器错误，请重新发送验证码"
            );
        }
        session_destroy();
        Response::json($ret);

    }

    public function sendMessage($templateNo, $repVar, $mblNo)
    {
        $params = array(
            "accountNo" => $this->accountNo,
            "pwd" => $this->pwd,
            "templateNo" => $templateNo,
            "mblNo" => $mblNo,
            "repVar" => $repVar
        );
        $query_url = $this->smsUrl."?".http_build_query($params);
//        die($query_url);

        return ApiHandle::httpGet($query_url);
    }
}
