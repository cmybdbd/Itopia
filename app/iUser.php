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

    public static function saveNewUser(string $json)
    {
        $info = \GuzzleHttp\json_decode($json);
    }

}
