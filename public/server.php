<?php
/**
 * Created by PhpStorm.
 * User: wjllance
 * Date: 2017/4/10
 * Time: 下午2:25
 */


include __DIR__ . '/vendor/autoload.php'; // 引入 composer 入口文件
use EasyWeChat\Foundation\Application;
$options = [
    'debug'  => true,
    'app_id' => 'wxd5494fb1aa9c9dbf',
    'secret' => 'bd332bb8aa7bbebf0710983c5f4a092e',
    'token'  => 'whatapity',
    'aes_key' => 'fxFIPtESqJHeNHbwb7jOdJiBLP7tTjtni1JIbcVnzus', // 可选
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！
    ],
    //...
];
$app = new Application($options);
$response = $app->server->serve();
// 将响应输出
$response->send();
