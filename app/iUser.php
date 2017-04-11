<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Uuids;
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

    public static function saveNewUser(string $json)
    {
        $info = \GuzzleHttp\json_decode($json);
    }

}
