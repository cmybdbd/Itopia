<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCallback extends Model
{
    //


    public static function saveServiceCallback($service, $serviceid, $uuid, $result)
    {
        $mod = new ServiceCallback();
        $mod->service=$service;
        $mod->serviceid=$serviceid;
        $mod->uuid=$uuid;
        $mod->result=json_encode($result);
        $mod->save();
    }
}
