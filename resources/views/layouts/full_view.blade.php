<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(isset($title) === true) {{ $title }} @else {{ __('app.pages.'.Route::currentRouteName()) }} @endif | {{ config('app.name', 'Docster') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('public/css/style.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/docster.css') }}" rel="stylesheet">

    @yield('header')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary position-absolute vw-100 zindex-fixed">
        <div class="container-fluid">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48" style="fill:#000000;">
                    <path id="svg_1" d="m40,45l-32,0l0,-42l22,0l10,10l0,32z" fill="#1976D2"/>
                    <path id="svg_2" d="m38.5,14l-9.5,0l0,-9.5l9.5,9.5z" fill="#E3F2FD"/>
                    <text font-weight="bold" xml:space="preserve" text-anchor="start" font-family="Junction, sans-serif" font-size="27" id="svg_4" y="35.6544" x="14.88236" stroke-opacity="null" stroke-width="0" stroke="null" fill="#ffffff">
                            {{ substr(config('app.name', 'D'), 0, 1) }}
                        </text>
                </svg>
            </div>
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Docster') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 mx-auto mt-5 py-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{URL::asset('public/js/docster.js')}}"></script>
@if(file_exists('public/js/page/'.Route::currentRouteName().'.js'))
    <!-- Page Specific Resources -->
    <script type="text/javascript" src="{{URL::asset('public/js/page/'.Route::currentRouteName().'.js')}}"></script>
@endif
@yield('scripts')
</body>
</html>
