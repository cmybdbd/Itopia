<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    Use Uuids;
    public $incrementing = false;
    protected $fillable = [
        'roomId'
    ];

    public static function add_password($room_id, $password_id, $password, $permission_begin, $permission_end)
    {
        $lock = new Lock();
        $lock->room_id = $room_id;
        $lock->password_id = $password_id;
        $lock->password = $password;
        $lock->permission_begin = date('Y-m-d H:i:s', $permission_begin);
        $lock->permission_end = date('Y-m-d H:i:s', $permission_end);
        $lock->save();
    }
}
