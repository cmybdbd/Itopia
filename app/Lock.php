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
}
