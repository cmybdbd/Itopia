<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoomController extends Controller
{
    function updateRoomInfo()
    {
    }
    function manageRoom()
    {

        return view('manage.room')->withRooms(Room::all());
    }
    function getRoomList()
    {}
    function getRoomState()
    {}
}
