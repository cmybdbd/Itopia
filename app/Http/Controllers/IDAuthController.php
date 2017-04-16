<?php

namespace App\Http\Controllers;

use App\ApiHandle;
use App\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class IDAuthController extends Controller
{
    //
//      线上
    private $api_url = 'https://open.wecash.net/query/v1/';
//  线下
//    private $api_url = "http://open-test.wecash.net:8180/query/v1/";
    private $source = "100302";
    private $key = "839B8DDB-5812-4103-BF1B-12B9C4E68022-20170407161502722-100302";

    public function IDauth()
    {

        $name = $_GET['name'];
        $idnumber = $_GET['id_card'];
        $timestamp = $this->getMillisecond();
        $service_type = "id_card_verify";
        $data_format_type = "origin";
        $params = array(
            "name" => $name,
            "id_card" => $idnumber,
            "timestamp" => $timestamp,
            "service_type" => $service_type,
            "data_format_type" => $data_format_type
        );
        $sign_arr = array_values($params);
        $sign_arr[] = $this->source;
        $sign_arr[] = $this->key;
        $params['signature'] = Utils::sign($sign_arr, true);
        $query_url = $this->api_url.$this->source."?".http_build_query($params);
        $res = ApiHandle::httpGet($query_url);
        if($res)
        {
            $res = json_decode($res, true);
            if($res['success'])
            {
                User::saveIDcard($idnumber, $name);
                $ret = array(
                    "code" => 200
                );
            }
            else
            {
                $ret = array(
                    "code" => 502,
                    "content" => $res
                );
            }
        }
        else
        {
            $ret = array(
                "code" => 501,
                "content" => "认证失败！"
            );
        }
        return Response::json($ret);
    }


    function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (string)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }
}
