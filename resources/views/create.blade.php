@extends('layouts.master', ['page_title' => 'Create new'])

@section('content')
    <form action="{{ action('GuestBookController@store') }}" method="post">
        @csrf
        <p>
            <label for="name">Your name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </p>
        <p>
            <label for="email">Your email address:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </p>
        <p>
            <label for="age">Your age:</label>
            <input type="tel" id="age" name="age" value="{{ old('age') }}">
            @if ($errors->has('age'))
                <span><strong>{{ $errors->first('age') }}</strong></span>
            @endif
        </p>
        <p>
            <label for="comment">Your comment:</label>
            <textarea name="comment" id="comment" cols="30" rows="10">{{ old('comment') }}</textarea>
            @if ($errors->has('comment'))
                <span><strong>{{ $errors->first('comment') }}</strong></span>
            @endif
        </p>
        <p>
            <button>Submit</button>
        </p>
    </form>
@endsection
