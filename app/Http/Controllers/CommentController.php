<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /*
     * createComment
     */
    function store()
    {

    }
    function create()
    {
        return view('comment.create');
    }
    function finish()
    {
        return view('comment.finish');
    }
}
