<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}{{ (' - ' . $page_title) ?? '' }}</title>
        
        {{-- Stylesheets --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        {{-- Scripts --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <h1>{{ config('app.name') }}</h1>
        
        @yield('content')
    </body>
</html>
