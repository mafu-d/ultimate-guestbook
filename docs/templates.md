# Templates

There's a common programming principle you may have come across - Don't Repeat Yourself (DRY). This usually refers to your PHP or Javascript code, which you can encapsulate into reusable functions. But what about your HTML? That's where the power of templates comes into play.

## Blade @extends

Inheritance. That's where one thing is related to another by a parent-child relationship. In our case, we're talking about HTML, which probably contain some similar markup, especially at the beginning and end. Across the site we're probably going to want the same stylesheets and scripts included, the same header and footer, and so on. So we can start tidying things up by placing all that common markup into a layout file, in our case `~/resources/views/layouts/master.blade.php`.

```blade
<html>
  <head>
    ...
  </head>
  <body>
    <h1>{{ config('app.name') }}</h1>
    
    @yield('content')
  </body>
</html>
```

Notice the `@yield('content')`. That defines a placeholder that we can fill with our own content in a child view.

```blade
@extends('layouts.master')
@section('content')
  Hello world!
@endsection
```
 
You can nest views inside each other to any level, too, which is handy.

## Blade @include and @component

There are other times when you want to include a bit of code in the other direction, i.e. pulling something into your view rather than pushing your view into the parent. A good example might be a common header navigation bar, which we might include in our layout view.

```blade
<body>
  @include('components.header')
  ...
</body>
```
 
Another useful approach is to create reusable components to standardise an element's markup. For example, it would be laborious (and risky) to have to remember exactly what classes and markup you needed to create a button, so we might put that into a reusable `~/resources/views/components/button.blade.php` component.

```blade
@if ($href ?? false)
  <a href="{{ $href }}" 
     class="button button--{{ $type ?? 'primary' }} {{ $classes ?? '' }}" 
     id="{{ $id ?? '' }}"
     target="{{ strpos($href, 'http') === 0 && strpos($href, config('app.url')) === false ? '_blank' : '_self' }}"
  >
    <span>{{ $label }}</span>
  </a>
@else
  <button class="button button--{{ $type ?? 'primary' }} {{ $classes ?? '' }}" id="{{ $id ?? '' }}">
    <span>{{ $label }}</span>
  </button>
@endif
```

```blade
@include('components.button', [
  'href' => 'https://somewhere.com',
  'label' => 'Go somewhere'
])
```

Hopefully you can see the power here. By making reusable components you may end up with your main view files containing more Blade than HTML, but it'll be more DRY and easier to maintain over time.

If you need your components to contain custom markup, or even other components, that's where `@component()` comes in. Your component can include a `@slot`, which is where the custom content will go. An example of this might be a reusable card, which we might put in `~/resources/views/components/card.blade.php`:

```blade
<div class="card">
  @if ($img_src ?? false)
    <figure class="card__image">
      <img src="{{ $img_src }}" alt="">
    </figure>
  @endif
  <div class="card__body">
    @if ($heading ?? false)
      <h3 class="card__heading">{{ $heading }}</h3>
    @endif
    {{ $slot }}
  </div>
</div>
```

Nothing too special going on here. We're optionally including an image and a heading, and then allowing whatever called the component to define what goes inside the `$slot`. From elsewhere, we might use it like this:

```blade
@component('components.card', ['heading' => 'Here is a heading'])
  <p>Here is some content.</p>
  <p>And something else.</p>
  @include('components.button', ['label' => 'Okay'])
@endcomponent
```

You don't need to stop there. You could use this component approach to create tables, unordered lists, embedded videos, navigation menus, hyperlinks... basically anything! If you need inspiration, take a look at Bulma's documentation; it logically separates things into single 'elements' and 'components' made from elements. You could use this sort of idea and make each element and component using Blade partials.

## Summary

There is much more that Blade can do as well (take a look at [stacks](https://laravel.com/docs/5.8/blade#stacks), for example), but the main point I want to make here is to think carefully about the architecture of your HTML markup so that you can structure your code well.

* Use `@extends` inheritance to standardise your page structure
* Split out large files and `@include` them together as needed
* Put as much as feasibly possible into components, and use them with `@include` or `@component`
