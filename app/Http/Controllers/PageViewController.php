<?php

namespace App\Http\Controllers;

use App\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{
    public static function updatePageView($page)
    {
        DB::update('update `pageView` set ? = ? + 1 where `date`= ?',
        [$page,$page, time()-time()%(24*60*60)]);
    }
}
