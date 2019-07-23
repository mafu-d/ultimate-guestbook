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

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $comment = new Comment([
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'comment' => $request->get('comment'),
        ]);
        $comment->save();

        return redirect(action('GuestBookController@index'));
    }
}
