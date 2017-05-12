<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

define("CODE_SUCCESSS", 200);
define("CODE_REDIRECT", 300);
define("CODE_AUTHORIZED", 401);
define("CODE_BALANCE_LOW", 402);
define("CODE_ERROR", 400);
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * 返回信息
     */
    protected function data($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
    }

    /*
     * 成功返回
     */
    protected function json($data)
    {
        header('Content-Type: application/json');
        die(json_encode(array(
            'code' => CODE_SUCCESSS,
            'content' => $data,
        )));
    }

    /*
     * 错误信息
     */
    protected function error($data = "获取失败", $code = CODE_ERROR)
    {
        header('Content-Type: application/json');
        die(json_encode(array(
            'code' => $code,
            'content' => $data,
        )));
    }
}
