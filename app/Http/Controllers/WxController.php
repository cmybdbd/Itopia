<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/10/17
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;


use EasyWeChat\Foundation\Application;
class WxController
{
    public function check_server()
    {
        $options = [
            'debug'  => true,
            'app_id' => 'wxd5494fb1aa9c9dbf',
            'secret' => 'bd332bb8aa7bbebf0710983c5f4a092e',
            'token'  => 'whatapity',
            'aes_key' => 'BcgOSFxOGe04PF5IdhVrMzSSMyn2NHYRdI20LaJZvcf', // 可选
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！
            ],
            //...
        ];
        $app = new Application($options);
        $response = $app->server->serve();
// 将响应输出
        return $response;
    }
}
