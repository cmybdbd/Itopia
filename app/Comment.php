<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public $incrementing = false;
    protected $fillable = ['starNum'];
}
