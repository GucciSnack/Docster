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

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item p-3" href="{{ route('account.manage') }}">
                                        {{ __('app.my_account') }}
                                    </a>
                                    <a class="dropdown-item p-3 d-none" href="{{ route('logout') }}">
                                        {{ __('app.my_documents') }}
                                    </a>
                                    <hr class="m-0 d-none" />
                                    <a class="dropdown-item p-3" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @guest
                <div class="guest-wrapper pt-5">
                    <h1 class="text-center my-5">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="196" height="196" viewBox="0 0 48 48" style="fill:#000000;">
                            <path id="svg_1" d="m40,45l-32,0l0,-42l22,0l10,10l0,32z" fill="#1976D2"/>
                            <path id="svg_2" d="m38.5,14l-9.5,0l0,-9.5l9.5,9.5z" fill="#E3F2FD"/>
                            <text font-weight="bold" xml:space="preserve" text-anchor="start" font-family="Junction, sans-serif" font-size="27" id="svg_4" y="35.6544" x="14.88236" stroke-opacity="null" stroke-width="0" stroke="null" fill="#ffffff">
                                {{ substr(config('app.name', 'D'), 0, 1) }}
                            </text>
                        </svg>
                    </h1>
                    <div class="col-md-5 mx-auto">
                        @yield('content')
                    </div>
                </div>
            @else
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 d-none d-lg-block p-0 bg-light vh-100">
                            <div class="mt-5 pt-3">
                                <div class="list-group">
                                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                <path d="M3,4 L20,4 C20.5522847,4 21,4.44771525 21,5 L21,7 C21,7.55228475 20.5522847,8 20,8 L3,8 C2.44771525,8 2,7.55228475 2,7 L2,5 C2,4.44771525 2.44771525,4 3,4 Z M10,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,13 C21,13.5522847 20.5522847,14 20,14 L10,14 C9.44771525,14 9,13.5522847 9,13 L9,11 C9,10.4477153 9.44771525,10 10,10 Z M10,16 L20,16 C20.5522847,16 21,16.4477153 21,17 L21,19 C21,19.5522847 20.5522847,20 20,20 L10,20 C9.44771525,20 9,19.5522847 9,19 L9,17 C9,16.4477153 9.44771525,16 10,16 Z" id="Combined-Shape" fill="#000000"/>
                                                <rect id="Rectangle-7-Copy-2" fill="#000000" opacity="0.3" x="2" y="10" width="5" height="10" rx="1"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.pages.dashboard')</span>
                                    </a>
                                    <a href="{{ route('template.index') }}" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <rect id="Rectangle" fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                                                <rect id="Rectangle-Copy" fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.pages.template.index')</span>
                                    </a>
                                    <a href="{{ route('document.create') }}" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" id="Combined-Shape" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.documents.add')</span>
                                    </a>
                                    <a href="{{ route('media') }}" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                <path d="M4.5,21 L21.5,21 C22.3284271,21 23,20.3284271 23,19.5 L23,8.5 C23,7.67157288 22.3284271,7 21.5,7 L11,7 L8.43933983,4.43933983 C8.15803526,4.15803526 7.77650439,4 7.37867966,4 L4.5,4 C3.67157288,4 3,4.67157288 3,5.5 L3,19.5 C3,20.3284271 3.67157288,21 4.5,21 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                <path d="M2.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,6.5 C21,5.67157288 20.3284271,5 19.5,5 L9,5 L6.43933983,2.43933983 C6.15803526,2.15803526 5.77650439,2 5.37867966,2 L2.5,2 C1.67157288,2 1,2.67157288 1,3.5 L1,17.5 C1,18.3284271 1.67157288,19 2.5,19 Z" id="Combined-Shape-Copy" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.pages.media')</span>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.users')</span>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action border-0 p-4 bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" id="Combined-Shape" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <span class="ml-2">@lang('app.settings')</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-10 mt-5 py-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @endguest
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
