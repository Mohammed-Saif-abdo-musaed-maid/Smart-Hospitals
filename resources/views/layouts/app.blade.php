<!DOCTYPE html>
@php
\App::setLocale(Session::get('locale'));
$app_locale = \App::getLocale();
$is_rtl = ($app_locale === 'ar');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $is_rtl ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Hospitals | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if($is_rtl)
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>