<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function getOrderDetail()
    {

    }
    function getOrderList()
    {

    }
    /*
     * show
     */
    function createOrder($id)
    {
        return view('order.create')->withRoom(Room::find($id));
    }
    /*
     * create
     */
    function storeOrder()
    {

    }
    function cancelOrder()
    {}
    function completeOrder()
    {}
    function handleWechatResult()
    {}
}
