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
}
