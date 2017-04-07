<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'userId', 'roomId', 'state',
    ];
}
