<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LockToken extends Model
{
    protected $table='dding_access_token';
    public $timestamps = false;
    //
    public static function get_access_token()
    {
        $token = LockToken::all();
        if($token->count() == 0)
        {
            return null;
        }
        else
        {
            $token = $token->first();
            var_dump($token);
            exit;
            if(strtotime($token->expires_time) < time())
            {
                $token->delete();
                return null;
            }
            else
            {
                return $token->access_token;
            }
        }
    }

    public static function save_access_token($params)
    {
        $token = new LockToken();
        $token->access_token=$params['access_token'];
        $token->expires_time=date('Y-m-d H:i:s', $params['expires_time']);
        $token->save();
        return $token->access_token;
    }
}
