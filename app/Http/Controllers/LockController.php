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
    private $home_id = '58cfc78d67df5d3251f0131d';
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

    private function addPassword($room_id, $password, $phonenumber, $permission_begin, $permission_end)
    {
        $query_url = $this->api_url.'/add_password';

        $params = array(
            "access_token" => $this->access_token(),
            "home_id" => $this->home_id,
            "room_id" => $room_id,
            "is_default" => 0,
            "is_send_location" => true,
            "password" => $password,
            "permission_begin" => $permission_begin,
            "permission_end" => $permission_end,
            'phonenumber' => $phonenumber
        );

        $res = ApiHandle::httpPostJson($query_url, $params);
        $res = json_decode($res, true);
        if($res['ErrNo'] != 0)
        {
            $ret = array(
                'code' => Constant::$STATUS_CODE['FAIL_ADD_PASSWORD'],
                'content' => $res
            );
        }
        else
        {
            $pwd_id = $res['id'];
            Lock::add_password($room_id, $pwd_id, $password, $permission_begin, $permission_end);
            $ret = array(
                'code' => Constant::$STATUS_CODE['OK'],
                'content' => "新增密码成功"
            );
        }
        return $ret;
    }

    private function deleteSparePasword($room_id)
    {
        $query_url = $this->api_url.'/delete_password';
        $spare_pswds = Lock::where([
            ['room_id', '=', $room_id],
            ['permission_end', '<', date('Y-m-d H:i:s', time())],
            ['state', '=', 1]
        ]);
        if($spare_pswds->count() > 0)
        {
            if($spare_pswds->count() > 2 )
            {
                $spare_pswds = $spare_pswds->get(2);
            }
            $params = array(
                'room_id' => $room_id,
                'access_token' => $this->access_token(),
                'home_id' => $this->home_id
            );
            foreach($spare_pswds->cursor() as $pswd)
            {
                $params['password_id'] = $pswd->password_id;
                $res = ApiHandle::httpPostJson($query_url, $params);
                $res = json_decode($res, true);
//                var_dump($res);
                if($res['ErrNo'] == 0)
                {
                    $pswd->state = 0;
                    $pswd->save();
                }
            }
        }
    }

    public function updatePassword($room_id, $password, $phonenumber, $permission_begin, $permission_end)
    {
        $this->deleteSparePasword($room_id);
        $ret = $this->addPassword($room_id, $password, $phonenumber, $permission_begin, $permission_end);
        return $ret;
    }


    /*fortest*/
    public function apiUpdatePassword()
    {
        $room_id = '58cff65e67df5d3251f0f356';
        $password = '324156';
        $phonenumber = '13021941487';
        $permission_begin = '1492707742';
        $permission_end = '1492707800';

        if(empty($room_id) || empty($password) || empty($phonenumber) || empty($permission_begin) || empty($permission_end))
        {
            $ret = array(
                'code' => Constant::$STATUS_CODE['PARAMS_MISS'],
                'content' => "参数错误"
            );
        }
        else
        {
            $ret = $this->updatePassword($room_id, $password, $phonenumber, $permission_begin, $permission_end);
        }
        return Response::json($ret);
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
