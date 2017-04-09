<?php

namespace App\Http\Controllers;

use App\Constant;
use App\WeiXinAuth;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function login()
    {
        $config = require ('../../../config/wechat.php');

        $app = new Application($config);
        $oauth = $app->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = '/home';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        // 已经登录过

        $user = $_SESSION['wechat_user'];


        $response = $app->oauth->scopes(['snsapi_userinfo'])
            ->redirect();

//        $redirectUrl = Constant::$LOGIN_URL;
//        $weinxinAuth = new WeiXinAuth();
//        $redirectUrl = $weinxinAuth->getAuthorizeURL($redirectUrl);
//        var_dump($redirectUrl);
//
//        header("Location: $redirectUrl");
//        exit();
    }

    public function oauth_callback()
    {

        $config = require ('../../../config/wechat.php');
        $app = new Application($config);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();
        $targetUrl = empty($_SESSION['target_url']) ? '/home' : $_SESSION['target_url'];


        var_dump($user).
        //header('location:'. $targetUrl); // 跳转到 user/profile
    }

}
