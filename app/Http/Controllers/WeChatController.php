<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/10/17
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;


use App\iUser;
use App\Order;
use App\User;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Redirect;

class WeChatController extends Controller
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
        $wechat = app('wechat');
        $response = $wechat->server->serve();
// 将响应输出
        return $response;
    }

    public function auth()
    {
        $user = session('wechat.oauth_user');
        // 未登录
        if (empty($user)) {
            $wechat = app('wechat');
            $oauth = $wechat->oauth;

            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        $u = \App\User::find($user->id);
        if(!$u)
        {
            $u = \App\User::create(['id'=>$user->id]);
        }
        \Illuminate\Support\Facades\Auth::login($u, true);
        $_SESSION['target_url'] = '/home';
        return redirect('home');
        // 已经登录过
      //  $user = $_SESSION['wechat_user'];
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
            iUser::saveNewUser($user->getOriginal());
        }

        $targetUrl = empty($_SESSION['target_url']) ? '/home' : $_SESSION['target_url'];
        return Redirect::to($targetUrl);
        //header('location:'. $targetUrl); // 跳转到目标url
    }

    function payment_call_back()
    {
        $wechat = app('wechat');
        $response = $wechat->payment->handleNotify(function($notify, $successful){
            // 你的逻辑


            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::find($notify->out_trade_no);
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->state > \Constant::$ORDER_STATE['UNPAY']) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
//                $order->paid_at = time(); // 更新支付时间为当前时间
                $order->state = \Constant::$ORDER_STATE['TOUSE'];
            } else { // 用户支付失败
                $order->state = \Constant::$ORDER_STATE['FAILED'];
            }
            $order->save(); // 保存订单

            return true; // 或者错误消息
        });
        return $response; // Laravel 里请使用：return $response;
    }

}
