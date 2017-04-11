<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class iUser extends Model
{
    use Uuids;
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
        $user->nickname = empty($userInfo['nickname'])?'':$userInfo['nickname'];
        $user->sex = empty($userInfo['sex'])?0:$userInfo['sex'];
        $user->province = empty($userInfo['province'])?'':$userInfo['province'];
        $user->city = empty($userInfo['city'])?'':$userInfo['city'];
        $user->country = empty($userInfo['country'])?'':$userInfo['country'];
        $user->headimgurl = empty($userInfo['headimgurl'])?'':$userInfo['headimgurl'];
        $user->privilege = empty($userInfo['privilege'])?'':$userInfo['privilege'];
        $user->unionid = empty($userInfo['unionid'])?'':$userInfo['unionid'];
        $user->save();

    }

}
