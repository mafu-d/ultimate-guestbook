@extends('layouts.master', ['page_title' => 'Home'])

@section('content')
    <p>
        <a href="{{ action('GuestBookController@create') }}">Post a new comment</a>
    </p>
    @foreach ($comments as $comment)
        <div class="comment">
            <h4>{{ $comment->name }} ({{ $comment->age()->format() }})</h4>
            <p><em>Posted at {{ $comment->created_at }}</em></p>
            <p>{!! str_replace("\n", '<br><br>', $comment->comment) !!}</p>
        </div>
    @endforeach
@endsection
