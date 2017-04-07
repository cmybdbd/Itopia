<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    public $incrementing = false;
    protected $fillable = [
        'address', 'type', 'hourPrice', 'nightPrice',
    ];
}
