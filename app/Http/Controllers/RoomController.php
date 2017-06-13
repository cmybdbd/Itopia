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
        //return Room::where('state' ,'<>',0)->get();
        $rooms = Room::where('state' ,'<>',0)->get();
        return view('manage.room')->with('rooms',$rooms)->with('choose',1);
    }
    function manageRoomById($rid)
    {
        $rooms = Room::where('state' ,'<>',0)->get();
        return view('manage.room')->with('rooms',$rooms)->with('choose',$rid);
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

    function roomUpdate(Request $request)
    {
        //return Response::json(['code' => '300','param' => '房间号有误']);

        $room = Room::find($request->id);
        
        if(empty($room))
            return Response::json(['code' => '300','param' => '房间号有误']);

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
            return Response::json(['code' => '200','param' => '修改成功']);
        }
        else
        {
            return Response::json(['code' => '300','param' => '保存失败']);
        }
    }
    
}
