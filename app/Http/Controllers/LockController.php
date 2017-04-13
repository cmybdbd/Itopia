<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\Constant;
use App\EventCallback;
use App\LockToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

//线上
//define('LOCK_API', 'https://lockapi.dding.net/openapi/v1/');

//线下
define('LOCK_API', 'http://115.28.141.204：8090/openapi/v1/');


class LockController extends Controller
{
    //线下
    private $client_id='c23b578799413d777340d7d2';
    private $client_secret='741a9ea72cf5c5c5f3051c8471de90c0';

    //线上
//    private $client_id='c23b578799413d777340d7d2';
//    private $client_secret='741a9ea72cf5c5c5f3051c8471de90c0';

    public function access_token()
    {
        $url = '/access_token';
        $token = LockToken::get_access_token();
        if(empty($token))
        {
            $params = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            );
            $ret = ApiHandle::httpPostJson(LOCK_API.$url, $params);
            $ret = json_decode($ret, true);
            if(isset($ret['ErrNo']))
            {
                die($ret);
            }
            else {
                $token = LockToken::save_access_token(json_decode($ret, true));
            }
        }
        return $token;
    }

    /*todo...*/
    public function update_password($access_token, $home_id, $room_id, $lock_uuid, $password_id, $password, $is_send_location, $phonenumber, $name, $permission_begin, $permission_end)
    {

        $url = '/update_password';
        $params = array(
            'access_token' => $this->access_token(),
            'permisson_begin' => $permission_begin,
        );
    }

    public function callback()
    {
        $event = $_POST['event'];
        $service = $_POST['service'];

        $ret = array(
            'ErrNo' => 0
        );
        if(empty($event) && empty($service))
        {
            $ret['ErrNo'] = 1;
            $ret['ErrMsg'] = "event or service miss";
            return Response::json($ret);
        }
        else
        {
            if(isset($event))
            {
                $time = $_POST['time'];
                $uuid = $_POST['uuid'];
                $home_id = $_POST['home_id'];
                $room_id = empty($_POST['room_id'])?'':$_POST['room_id'];
                $nickname = $_POST['nickname'];
                $detail = empty($_POST['detail'])?'':$_POST['detail'];
                if(empty($time))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'time miss'
                    );
                    return Response::json($ret);
                }
                if(empty($uuid))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'uuid miss'
                    );
                    return Response::json($ret);
                }
                if(empty($home_id))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'home_id miss'
                    );
                    return Response::json($ret);
                }
                if(empty($nickname))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'nickname miss'
                    );
                    return Response::json($ret);
                }
                if(!in_array($event, Constant::$elemeterEvent) || !in_array($event, Constant::$normalEvent))
                {

                    $ret = array(
                        'ErrNo' => 2,
                        'ErrMsg' => 'not a event name'
                    );
                    return Response::json($ret);
                }
                EventCallback::saveEventCallback($time, $uuid, $home_id, $room_id, $nickname, $detail);
                return Response::json($ret);
            }
            if(isset($service))
            {
                $service = $_POST['service'];
                $serviceid = $_POST['serviceid'];
                $uuid = $_POST['uuid'];
                $result = $_POST['result'];
                if(empty($service))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'service miss'
                    );
                    return Response::json($ret);
                }
                if(empty($serviceid))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'serviceid miss'
                    );
                    return Response::json($ret);
                }
                if(empty($uuid))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'uuid miss'
                    );
                    return Response::json($ret);
                }
                if(empty($result))
                {
                    $ret = array(
                        'ErrNo' => 1,
                        'ErrMsg' => 'result miss'
                    );
                    return Response::json($ret);
                }
                if(!in_array($service, Constant::$elemeterService) || !in_array($event, Constant::$pswdService))
                {
                    $ret = array(
                        'ErrNo' => 2,
                        'ErrMsg' => 'not a service name'
                    );
                    return Response::json($ret);
                }
                EventCallback::saveEventCallback($service, $serviceid, $uuid, $result);
                return Response::json($ret);
            }
        }

    }

}
