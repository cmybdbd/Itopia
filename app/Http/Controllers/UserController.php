<?php

namespace App\Http\Controllers;

use App\Constant;
use App\WeiXinAuth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function login()
    {
        $code = @$_GET['code'];
        if (empty($code))
        {
            $this->error('获取微信code失败');
        }

        $weixinAuth = new WeiXinAuth();
        $data = $weixinAuth->getAccessToken($code);

        $accessToken = $data['access_token'];
        $openId=$data['openid'];

        /*
        if (empty($data) || !isset($data['access_token']) || !isset($data['openid']))
        {
            // 有可能存在用户点击返回因而重新刷新了该URL
            $userLogin = new UserLogin();
            $user = $userLogin->userinfo();
            $uid = @$user['uid'];
            if (empty($uid))
            {
                $this->error("获取微信access_token失败|$code");
            }
        }
        else
        {
            $openId = $data['openid'];
            $userInfo = new UserinfoModel();
            $channel = 'wx';
            $user = $userInfo->getUser($channel, $openId);
        }
        */
        

        $user = $weixinAuth->getUserInfo($accessToken, $openId);

        if (empty($user))
        {
            $this->error("获取微信用户信息失败|$accessToken|$openId");
        }


        var_dump($user);

        //header("Location: ".Constant::$HOME_URL);
    }

    public function wxAuth()
    {
        $redirectUrl = Constant::$LOGIN_URL;
        $weinxinAuth = new WeiXinAuth();
        $redirectUrl = $weinxinAuth->getAuthorizeURL($redirectUrl);
        var_dump($redirectUrl);

        header("Location: $redirectUrl");
        exit();
    }

}
