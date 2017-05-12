<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    function index(){
        PageViewController::updatePageView('home');
        return view('frontpage')->withRooms(Room::get());

    }
}
