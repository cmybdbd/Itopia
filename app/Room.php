<?php

namespace App;

use App\Utils\Constant;
use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class Room extends Model
{
    use Uuids;
    //
    public $incrementing = false;
    protected $fillable = [
        'address', 'type', 'hourPrice', 'nightPrice',
    ];
    public function hasManyOrders(){
        return $this->hasMany('App\Order','roomId','id');
    }

    public function usingNight(){
        $night = $this->hasManyOrders()->where([
            ['isDay' , '=', 0],
            ['startDate', ">=", Utils::curNight()],
            ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
        ])->pluck('startDate');
        $res = [];
        foreach ($night as $n)
            $res[] = $n;
        return json_encode($res);
    }
    public function isUsing()
    {
        $hour = date('H',time());
        if($hour <=  5 || $hour == 23)
        {
            //return json_encode([Utils::curNight(),$this->usingNight()]);
            return in_array(date('Y-m-d H:i:s',Utils::curNight()), json_decode($this->usingNight()));
        }
        else
        {
            if($hour < 11)
            {
                $time =  strtotime(date('Y-m-d 00:00:00',time()))+11*60*60;
            }
            else
            {
                $time = time();
            }
            $starttime = date('Y-m-d H:i:s', $time+30*60);
            $endtime = date('Y-m-d H:i:s', $time - 30*60);
            $used = $this->hasManyOrders()->where([
                ['startTime', '<=', $starttime],
                ['endTime', '>=', $endtime],
                ['isDay', '=', 1],
                ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
            ])->get();

            return count($used);
        }
    }
    public function nextTime(){
        $nextTime = $this -> hasManyOrders()->where([
            ['state','>=', Constant::$ORDER_STATE['UNPAY']],
            ['isDay', '=', 1],
        ])->max('endTime');
        if(empty($nextTime))
        {
            $nextTime= 0;
        }
        else
        {
            $nextTime = strtotime($nextTime) + 30 * 60;
        }

        $dayStartTime = strtotime(date('Y-m-d 00:00:00', time()));
        $dayMaxTime = $dayStartTime + 22 * 60 * 60;

        $time = time() - time() % (30*60) + 30*60;
        $time = $time > $dayStartTime + 11*60*60 ? $time : $dayStartTime + 11*60*60;

        if ($dayMaxTime > $nextTime && $dayMaxTime > $time)
        {
            return $nextTime > $time ? $nextTime:$time;
        }
        else if($time > $dayMaxTime && $nextTime < $time)
        {
            return $dayStartTime + 35*60*60;
        }
        return 0;
    }
}
