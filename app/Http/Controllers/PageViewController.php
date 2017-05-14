<?php

namespace App\Http\Controllers;

use App\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{

    public static function updatePageView($page)
    {
        //$time = time() - time() %(24*60*60) - 8*60*60;
        $date = (date('Y-m-d 00:00:00', time()));
        //$date = date('Y-m-d H:i:s',$time);
        $pageView =PageView::where('curDate' ,'=', $date)->first();
        if(!count($pageView))
        {
            $pageView = new PageView();

            $pageView->home = 0;
            $pageView->create = 0;
            $pageView->result = 0;
            $pageView->comment = 0;
            $pageView->commentResult = 0;
            $pageView->orderList = 0;
            $pageView-> useHour = 0;
            $pageView-> useNight = 0;
        }
        $pageView->curDate = $date;
        $pageView->$page += 1;
        $pageView->save();
        //DB::update('update pageView set `'.$page.'` = `'.$page.'` + 1 where `date`= "'.$date.'"');
    }
}
