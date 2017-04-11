<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\LockToken;
use Illuminate\Http\Request;

//线上
//define('LOCK_API', 'https://lockapi.dding.net/openapi/v1/');

//线下
define('LOCK_API', 'http://115.28.141.204：8090/openapi/v1/');


class LockController extends Controller
{
    //
    private $client_id='';
    private $client_secret='';

    public function access_token()
    {
        $token = LockToken::get_access_token();
        if(empty($token))
        {
            $params = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            );
            $ret = ApiHandle::httpPostJson(LOCK_API.'/access_token', $params);
            $token = LockToken::save_access_token(json_decode($ret, true));
        }
        return $token;
    }


}
