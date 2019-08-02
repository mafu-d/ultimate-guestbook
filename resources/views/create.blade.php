@extends('layouts.master', ['page_title' => 'Create new'])

@section('content')
  <form action="{{ action('GuestBookController@store') }}" method="post">
    @csrf
    @include('components.text-input', [
      'id' => 'name',
      'name' => 'name',
      'label' => 'Your name',
      'value' => old('name'),
      'required' => true
    ])
    @include('components.text-input', [
      'id' => 'email',
      'name' => 'email',
      'label' => 'Your email address',
      'type' => 'email',
      'value' => old('email'),
      'required' => true
    ])
    @include('components.text-input', [
      'id' => 'age',
      'name' => 'age',
      'label' => 'Your age',
      'type' => 'tel',
      'value' => old('age'),
      'required' => true
    ])
    @include('components.textarea', [
      'id' => 'comment',
      'name' => 'comment',
      'label' => 'Your comment',
      'value' => old('comment'),
      'required' => true
    ])
    <p>
      @include('elements.button', ['label' => 'Submit'])
    </p>
  </form>
@endsection
