<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCallback extends Model
{
    //
    public $timestamps = false;

    public static function saveEventCallback($time, $uuid, $home_id, $room_id, $nickname, $detail)
    {
        $mod = new EventCallback();
        $mod->time=$time;
        $mod->uuid=$uuid;
        $mod->home_id=$home_id;
        $mod->room_id=$room_id;
        $mod->nickname=$nickname;
        $mod->detail=json_encode($detail);
        $mod->save();
    }
}
