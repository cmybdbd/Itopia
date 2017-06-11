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

    public function isNightBooked($id)
    {

        $night = $this->hasManyOrders()->where([
            ['isDay' , '=', 0],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']],
            ['state', "<", Constant::$ORDER_STATE['HISTORY']]
        ])->where('startTime','>=',date('Y-m-d', time()+24*60*60*$id) )->where('startTime','<=',date('Y-m-d', time()+24*60*60*($id+1)) )->max('startTime');
        if(empty($night))
            return 0;
        else
            return 1;

    }
    public function usingNight(){
        $night = $this->hasManyOrders()->where([
            ['isDay' , '=', 0],
            ['startDate', ">=", Utils::curNight()],
            ['state', '>=', Constant::$ORDER_STATE['COMPLETE']],
            ['state', "<", Constant::$ORDER_STATE['HISTORY']]
        ])->pluck('startDate');
        $res = [];
        foreach ($night as $n)
            $res[] = $n;
        return json_encode($res);
    }
    public function isUsing()
    {
        $use = $this->today_nextTime();
        if($use >= 0 && $use < time())
            return 0;
        if($use == -1)
            return -1;
        else 
            return 1;
    }
    public function nextTime(){
        $nextTime = $this -> hasManyOrders()->where([
            ['state','>=', Constant::$ORDER_STATE['COMPLETE']],
            ['state', '<', Constant::$ORDER_STATE['HISTORY']],
            ['isDay', '=', 1],
        ])->where('endTime','<',date('Y-m-d 00:00:00', time()+24*60*60))->max('endTime');
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
        $time = $time > $dayStartTime + 12*60*60 ? $time : $dayStartTime + 12*60*60;

        if ($dayMaxTime > $nextTime && $dayMaxTime > $time)
        {
            return $nextTime > $time ? $nextTime:$time;
        }
        else if($time > $dayMaxTime && ($nextTime-60*60) < $time)
        {
            return $dayStartTime + 35*60*60;
        }
        return 0;
    }

    public function today_nextTime()
    {
        $tmp = $this->nextUsingTime();
        $type = $this->type;
        $day_start_time = strtotime(date('Y-m-d 12:00:00', time())) - $type/2*60*60;
            //type A = 1 , 11:30 begin
            //type B = 0 , 12:00 begin 
        $day_end_time = strtotime(date('Y-m-d 21:00:00', time())) - $type/2*60*60;
            //type A , 20:30 end
            //type B , 21:00 end
        if(time() >= $day_end_time)
            return -1;

        if($tmp == -1)
        {
            return -1;
        }

        if($tmp == 0)
        {
            $time = time() - time()%(30*60) + 30*60;
            if($time <= $day_start_time)
                return $day_start_time;
            if($time > $day_end_time)
                return -1;
            return $time;
        }

        $next_time = $tmp - $tmp%(30*60) + 30*60;
        if($next_time > $day_end_time)
            return -1;
        if($next_time > time())
            return $next_time;
        else
        {
            $time = time() - time()%(30*60) + 30*60;
            if($time > $day_end_time)
                return -1;
            return $time;
        }


    }
    public function next_day_time()
    {
        $tmp = $this->nextDayUsingTime();
        $type = $this->type;
        $day_start_time = strtotime(date('Y-m-d 12:00:00', time() + 24*60*60)) - $type/2*60*60;
            //type A = 1 , 11:30 begin
            //type B = 0 , 12:00 begin 
        $day_end_time = strtotime(date('Y-m-d 21:00:00', time() + 24*60*60)) - $type/2*60*60;
            //type A , 20:30 end
            //type B , 21:00 end
        if($tmp == -1)
        {
            return -1;
        }

        if($tmp == 0)
        {
            return $day_start_time;
        }

        $next_time = $tmp - $tmp%(30*60) + 30*60;
        if($next_time > $day_end_time)
            return -1;
        return $next_time;
    }
    public function nextDayUsingTime(){//nextDay
        $nextTime = $this -> hasManyOrders()->where([
            ['state','>=', Constant::$ORDER_STATE['COMPLETE']],
            ['state', '<', Constant::$ORDER_STATE['HISTORY']],
            ['isDay', '=', 1],
        ])->where('endTime','<=',date('Y-m-d 23:30:00', time()+24*60*60))->where('endTime','>',date('Y-m-d 00:00:00', time()+24*60*60))->max('endTime');
        if(empty($nextTime))
        {
            $nextTime= 0;
        }
        else
        {
            $nextTime = strtotime($nextTime);
        }
        $tmptime = strtotime(date('Y-m-d 21:00:00', time()+24*60*60)) - $this->type/2*60*60;
        if($nextTime > $tmptime) 
            return -1;
        else 
            return $nextTime;
        return 0;
    }
    public function nextUsingTime(){//today
        $nextTime = $this -> hasManyOrders()->where([
            ['state','>=', Constant::$ORDER_STATE['COMPLETE']],
            ['state', '<', Constant::$ORDER_STATE['HISTORY']],
            ['isDay', '=', 1],
        ])->where('endTime','<=',date('Y-m-d 23:30:00', time()))->where('endTime','>',date('Y-m-d 00:00:00', time()))->max('endTime');
        if(empty($nextTime))
        {
            $nextTime= 0;
        }
        else
        {
            $nextTime = strtotime($nextTime);
        }
        $tmptime = strtotime(date('Y-m-d 21:00:00', time())) - $this->type/2*60*60;
        if($nextTime > $tmptime) 
            return -1;
        else 
            return $nextTime;
        return 0;
    }
}
