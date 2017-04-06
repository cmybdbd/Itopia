<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = [
        'address', 'type', 'hourPrice', 'nightPrice',
    ];
}
