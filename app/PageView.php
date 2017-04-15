<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'pageView';
    protected $guarded = [];
    public $incrementing = false;
    protected $primaryKey='curDate';
    //
}
