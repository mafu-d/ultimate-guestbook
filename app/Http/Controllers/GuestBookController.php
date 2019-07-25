<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
        try {
            $comment = new Comment([
                'name'    => $request->get('name'),
                'email'   => $request->get('email'),
                'age'     => $request->get('age'),
                'comment' => $request->get('comment'),
            ]);
            $comment->save();
        } catch (ValidationException $exception) {
            Log::info('Comment submitted but invalid', [
                'data'   => $request->except(['_token']),
                'errors' => $exception->validator->errors()->toArray(),
            ]);
            throw $exception;
        }

        return redirect(action('GuestBookController@index'));
    }
}
