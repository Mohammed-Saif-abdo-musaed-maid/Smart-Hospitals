<!DOCTYPE html>
@php
\App::setLocale(Session::get('locale'));
$app_locale = \App::getLocale();
$is_rtl = ($app_locale === 'ar');
@endphp
<html lang="{{ $app_locale }}" dir="{{ $is_rtl ? 'rtl' : 'ltr' }}">

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link type="text/css" rel="stylesheet" href="./css/theme.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="./jquery/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <title>@yield('title')</title>

    @if($is_rtl)
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif

    <style>

.spinner {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 60px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            z-index: 9999;
        }

        .spinner>div {

            background-color: #2A98E5;
            height: 100%;
            width: 6px;
            display: inline-block;

            -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
            animation: sk-stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes sk-stretchdelay {

            0%,
            40%,
            100% {
                -webkit-transform: scaleY(0.4)
            }

            20% {
                -webkit-transform: scaleY(1.0)
            }
        }

        @keyframes sk-stretchdelay {

            0%,
            40%,
            100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }

            20% {
                transform: scaleY(1.0);
                -webkit-transform: scaleY(1.0);
            }
        }

        #preloader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-repeat: no-repeat;
            background-color: #F9FDFF;
            background-position: center;
        }

        body,
        html {
            height: 100%;
        }

    </style>

</head>

<body class="bg-dark">

    @section('navbar')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand text-white">@yield('app_title')</span>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        @if($app_locale == 'si')
                        සිං
                        @elseif($app_locale == 'ar')
                        عربى
                        @else
                        EN
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('lang', 'en') }}">{{ __('English') }}</a>
                        <a class="dropdown-item" href="{{ route('lang', 'si') }}">සිංහල</a>
                        <a class="dropdown-item" href="{{ route('lang', 'ar') }}">العربية</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    @show

        <div id="preloader"></div>
        <div id="spinner" class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>


    @yield('content')
    <script>
            $("#preloader").fadeOut();
            $("#spinner").fadeOut();
            </script>
</body>

</html>
