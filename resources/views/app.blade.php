<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/theme1.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/cms.min.css') }}">

        <!-- Scripts -->
        @routes()
{{--        <script src="{{ asset('js/app.min.js') }}" defer></script>--}}
    </head>
    <body class="font-sans antialiased">
    @inertia
    <div id="fm"></div>
    <script src="{{ mix('js/app.min.js') }}" defer></script>
{{--        @env ('local')--}}
{{--            <script src="http://localhost:8080/js/bundle.js"></script>--}}
{{--        @endenv--}}
    </body>
</html>
