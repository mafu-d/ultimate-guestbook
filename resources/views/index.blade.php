<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <h1>{{ config('app.name') }}</h1>
        <p>
            <a href="{{ action('GuestBookController@create') }}">Post a new comment</a>
        </p>
        @foreach($comments as $comment)
            <div class="comment">
                <h4>{{ $comment->name }}</h4>
                <p><em>Posted at {{ $comment->created_at }}</em></p>
                <p>{!! str_replace("\n", '<br><br>', $comment->comment) !!}</p>
            </div>
        @endforeach
    </body>
</html>
