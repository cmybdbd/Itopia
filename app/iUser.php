<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class iUser extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openid', 'nickname', 'sex', 'province', 'city', 'country', 'headimgurl', 'privilege', 'unionid'
    ];

    protected $table='i_users';

    public static function saveNewUser($userInfo)
    {
        $user = new iUser();
        $user->openid = $userInfo['openid'];
        $user->nickname = $userInfo['nickname'];
        $user->sex = $userInfo['sex'];
        $user->province = $userInfo['province'];
        $user->city = $userInfo['city'];
        $user->country = $userInfo['country'];
        $user->headimgurl = $userInfo['headimgurl'];
        $user->privilege = $userInfo['privilege'];
        $user->unionid = $userInfo['unionid'];
        $user->save();

    }

}
