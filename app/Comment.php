<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Uuids;
    //
    public $incrementing = false;
    protected $guarded = [];
}
