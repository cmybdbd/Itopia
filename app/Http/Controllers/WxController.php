<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/10/17
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;


use EasyWeChat\Foundation\Application;
class WxController extends Controller
{
    public function check_server()
    {
        $options = [
            //'debug'  => true,
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

    public function auth()
    {
        $config = [
            // ...
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/oauth_callback',
            ],
            // ..
        ];
        $app = new Application($config);
        $oauth = $app->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = 'user/profile';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        // 已经登录过
        $user = $_SESSION['wechat_user'];
    }

    public function call_back()
    {
        $config = [
            // ...
        ];
        $app = new Application($config);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();
        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
        header('location:'. $targetUrl); // 跳转到 user/profile
    }
}
