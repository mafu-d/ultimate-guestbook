@extends('layouts.master', ['page_title' => 'Home'])

@section('content')
  <p>
    @include('elements.button', [
      'label' => 'Post a new comment',
      'href' => action('GuestBookController@create'),
    ])
  </p>
  @foreach ($comments as $comment)
    @component('components.card', [
      'classes' => 'comment',
      'heading' => $comment->name . ' (' . $comment->age()->format() . ')'
    ])
      <p><em>Posted at {{ $comment->created_at }}</em></p>
      <p>{!! str_replace("\n", '<br><br>', $comment->comment) !!}</p>
    @endcomponent
  @endforeach
@endsection
