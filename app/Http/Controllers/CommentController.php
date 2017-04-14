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
        PageViewController::updatePageView('comment');
        return view('comment.create');
    }
    function finish()
    {
        PageViewController::updatePageView('commentResult');
        return view('comment.finish');
    }
}
