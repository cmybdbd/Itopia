<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SMSController extends Controller
{
    //

    private $accountNo = 'accountNo:rent2';
    private $pwd = 'bcv86vcs9ip11m';

    private $smsUrl = 'http://sms.wecash.net/sms-platform/sms/sendSMSCode';

    public function sendCode()
    {
        $mblNo = Input::get('mblNo');
        $templateNo = 'MNY001';
        $repVar = '8807';
        $ret = $this->sendMessage($templateNo, $repVar, $mblNo);
        if($ret)
        {
            return Response::json($ret);
        }
        else
        {
            return Response::json(
                array(
                    'code' => "501",
                    "content" => "发送失败，请重试"
                )
            );
        }
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
        $query_url = $this->smsUrl.http_build_query($params);
        return http_get($query_url);
    }
}
