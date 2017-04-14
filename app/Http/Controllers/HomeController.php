<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function index(){
        PageViewController::updatePageView('home');
        return view('frontpage')->withRooms(Room::limit(5)->get());

    }
}
