<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\EventCallback;
use App\Lock;
use App\LockToken;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class LockController extends Controller
{
    //线下
    private $home_id = 'lkjl0011170300183734';
    private $client_id='c23b578799413d777340d7d2';
    private $client_secret='741a9ea72cf5c5c5f3051c8471de90c0';
    private $api_url = 'https://lockapi.dding.net/openapi/v1';

    //线上
//    private $client_id='c23b578799413d777340d7d2';
//    private $client_secret='741a9ea72cf5c5c5f3051c8471de90c0';

    public function access_token()
    {
        $query_url = $this->api_url.'/access_token';
        $token = LockToken::get_access_token();
        if(empty($token))
        {
            $params = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            );
            $ret = ApiHandle::httpPostJson($query_url, $params);

            $ret = json_decode($ret, true);
            if($ret['ErrNo'] != 0 )
            {
                die($ret);
            }
            else {
                $token = LockToken::save_access_token($ret);
            }
        }
        return $token;
    }

    public function addPassword()
    {
        $query_url = $this->api_url.'/add_password';

        $room_id = $_GET['room_id'];
//        $is_default = $_GET['is_default'];
        $password = $_GET['password'];
        $permisson_begin = $_GET['permission_begin'];
        $permisson_end = $_GET['permission_end'];

        $is_default = isset($_GET['is_default'])?$_GET['is_default']:0;

        if(empty($room_id) || empty($password) || empty($permisson_begin) || empty($permisson_end))
        {
            $ret = array(
                "code" => Constant::$STATUS_CODE['PARAMS_MISS'],
                "content" => "params miss"
            );
            return Response::json($ret);
        }

        $params = array(
            "access_token" => $this->access_token(),
            "home_id" => $this->home_id,
            "room_id" => $room_id,
            "is_default" => $is_default,
            "is_send_location" => true,
            "password" => $password,
            "permission_begin" => $permisson_begin,
            "permission_end" => $permisson_end
        );

        $phone = $_GET['phone'];
        if(isset($phone))
        {
            $params['phonenumber'] = $phone;
        }

        $res = ApiHandle::httpPostJson($query_url, $params);
        $res = json_decode($res, true);
        if($res['ErrNo'] != 0)
        {
            return Response::json($res);
        }
        else
        {
            $pwd_id = $res['id'];
            Lock::add_password($room_id, $pwd_id, $password, $permisson_begin, $permisson_end);
            $ret = array(
                'code' => Constant::$STATUS_CODE['OK']
            );
            return Response::json($ret);
        }

    }

    /*todo...*/
    public function update_password($room_id, $password_id, $password, $phonenumber, $permission_begin, $permission_end)
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
