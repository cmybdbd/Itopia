<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = [
        'userId', 'roomId', 'state',
    ];
    public function hasRoom(){
        return $this->belongsTo('App\Room','roomId', 'id');
    }
    public function hasUser(){
        return $this->belongsTo('App\User', 'userId', 'id');
    }


}
