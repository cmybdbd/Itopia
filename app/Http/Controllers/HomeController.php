<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function index(){
        return view('frontpage')->withRooms(Room::limit(5)->get());
    }
}
