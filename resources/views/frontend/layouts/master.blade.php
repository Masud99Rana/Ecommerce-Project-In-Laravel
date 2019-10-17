<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    @yield('before_head')
</head>
<body>

@include('frontend.partials._header')

<main role="main" id="app">

    @yield('main')

</main>

@include('frontend.partials._footer')

<script src="{{ mix('js/all.js') }}"></script>
@yield('before_body')
</body>
</html>
