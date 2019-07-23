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
        <form action="{{ action('GuestBookController@store') }}" method="post">
            @csrf
            <p>
                <label for="name">Your name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @if($errors->has('name'))
                    <span><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </p>
            <p>
                <label for="email">Your email address:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </p>
            <p>
                <label for="comment">Your comment:</label>
                <textarea name="comment" id="comment" cols="30" rows="10">{{ old('comment') }}</textarea>
                @if($errors->has('comment'))
                    <span><strong>{{ $errors->first('comment') }}</strong></span>
                @endif
            </p>
            <p>
                <button>Submit</button>
            </p>
        </form>
    </body>
</html>
