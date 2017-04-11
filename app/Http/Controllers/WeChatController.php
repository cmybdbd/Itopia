<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/10/17
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;


use App\iUser;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class WeChatController extends Controller
{
    public function check_server()
    {
        $wechat = app('wechat');
        $response = $wechat->server->serve();
// 将响应输出
        return $response;
    }

    public function auth()
    {
        $wechat = app('wechat');
        $oauth = $wechat->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = '/home';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        // 已经登录过
        $user = $_SESSION['wechat_user'];
    }

    public function call_back()
    {
        $wechat = app('wechat');
        $oauth = $wechat->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();


        $count = iUser::where('openid', $user->getId())->count();

        if($count == 0)
        {
            Log::info("new user");
            iUser::saveNewUser($user->getOriginal());
        }
        else {

            Log::info("old user");
        }

        $targetUrl = empty($_SESSION['target_url']) ? '/home' : $_SESSION['target_url'];
        return Redirect::to($targetUrl);
        //header('location:'. $targetUrl); // 跳转到目标url
    }
}
