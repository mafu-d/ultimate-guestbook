<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index()
    {
        $comments = Comment::all();

        return view('index', ['comments' => $comments]);
    }
}
