<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;


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

    public static function saveNewUser($userInfo)
    {
        //todo emoji name
        $user = new User();
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
        return $user;
    }

    public static function savePhone($phone, $id = null)
    {
        $user = User::getUser($id);
        $user->phonenumber = $phone;
        $user->save();
    }

    public static function saveIDcard($idnumber, $name, $id = null)
    {
        $user = User::getUser($id);
        $user->idnumber = $idnumber;
        $user->name = $name;
        $user->save();
    }

    public static function getUser($id = null)
    {
        if($id == null)
        {
            $id = Auth::id();
        }
        return User::find($id);
    }
}
