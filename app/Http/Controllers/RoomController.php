<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoomController extends Controller
{
    function updateRoomInfo(Request $request)
    {
        $room = Room::find($request->id);

        if(!empty($request->title))
        {
            $room->title = $request->title;
        }
        if(!empty($request->address))
        {
            $room->address = $request->address;
        }
        if(!empty($request->hourPrice))
        {
            $room->hourPrice = $request->hourPrice;
        }
        if(!empty($request->nightPrice))
        {
            $room->nightPrice = $request->nightPrice;
        }
        if(!empty($request->number))
        {
            $room->phoneOfManager = $request->number;
        }
        if($room->save())
        {
            return redirect() -> back() ;
        }
        else
        {
            return redirect() -> back() ->withInput()->withErrors('保存失败');
        }
    }
    function manageRoom()
    {

        return view('manage.room')->withRooms(Room::where('state' ,'<>',0)->get());
    }
    function getRoomList()
    {}
    function getRoomState()
    {}
    function isRoomNightBooked($rid,$day)
    {
        $room = Room::find($rid);
        if($room->isNightBooked($day))
            $res = 0;
        else
            $res = 1;
        return Response::json(['isBooked' => $res]);
    }
    
}
