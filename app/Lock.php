<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'roomId'
    ];
}
