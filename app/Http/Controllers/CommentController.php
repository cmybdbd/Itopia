<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Order;
use App\Utils\Utils;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    /*
     * createComment
     */
    function store(Request $request)
    {
        $this->validate($request,[
                'starNum'=>'required',
                'userId' => 'required',
                'orderId' => 'required',
        ]);
        $comment = new Comment();
        $comment -> userId = $request->userId;
        $comment -> orderId = $request->orderId;
        $comment -> starNum = $request->starNum;
        $comment -> content = $request->text;
        $comment-> tags = $request->tags;
        $comment->state = 1;
        $res = $comment->save();
        Order::find($request->orderId)->update(['state'=> Constant::$ORDER_STATE['HISTORY']]);
        if($res)
        {
            return Response::json(['code'=>200]);
        }
        else
        {
            return Response::json(['code'=>300]);
        }
    }
    function create($id)
    {
        PageViewController::updatePageView('comment');
        return view('comment.create')->with(['oid'=>$id]);
    }
    function finish()
    {
        PageViewController::updatePageView('commentResult');
        return view('comment.finish');
    }
}
