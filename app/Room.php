<?php

namespace App;

use App\Utils\Constant;
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
    public function isUsing(){

        if(time() % (24*60*60) > 12 * 60*60)
        {
            //night
            $time = date('Y-m-d H:i:s', time());
            $dayStartTime = time() - time() % (24*60*60) - 8*60*60;
            $used = $this->hasManyOrders()->where([
                ['startDate', '<', $dayStartTime + 24*60*60],
                ['startDate', '>=', $dayStartTime],
                ['isDay' ,'=', false],
                ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
            ])->get();
            if(count($used))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $time = date('Y-m-d H:i:s', time());
            $used = $this->hasManyOrders()->where([
                ['startTime', '<=', $time],
                ['endTime', '>=', $time],
                ['isDay', '=', true],
                ['state', '>=', Constant::$ORDER_STATE['UNPAY']],
            ])->get();

            if (count($used))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    public function nextTime(){
        $nextTime = $this -> hasManyOrders()->where([
            ['state','>=', Constant::$ORDER_STATE['UNPAY']],
            ['isDay', '=', true],
        ])->max('endTime');
        $nextTime = strtotime($nextTime) + 30 * 60;

        $dayStartTime = time() - time() % (24 * 60 * 60) - 8 * 60 * 60;
        $dayMaxTime = $dayStartTime + 22 * 60 * 60;

        $time = time() - time() % (30*60) + 30*60;
        if ($dayMaxTime > $nextTime && $dayMaxTime > $time)
        {
            return $nextTime > $time ? $nextTime:$time;
        }
        return -1;
    }
}
