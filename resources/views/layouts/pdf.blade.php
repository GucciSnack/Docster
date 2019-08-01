<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $name }} | Preview</title>

        <!-- Styles -->
        <link href="{{ asset('public/css/style.bundle.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/docster.css') }}" rel="stylesheet">
    </head>
    <body>
        @yield('document')
    </body>
</html>
