<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        @include('layouts.navigation-guest')
        <div class="font-sans text-gray-900 antialiased flex flex-col items-center justify-center w-full p-7">
            {{ $slot }}
        </div>
        <div class="background fixed left-0 top-0 w-full">

        </div>

        @include('layouts.footer')
    </body>
</html>

<style>
    .background {
        background-repeat: no-repeat;
        background-image: url('/img/background_league.jpg');
        background-size: cover;
        height: 100%;
        z-index: -1;
        opacity: .05;
    }
</style>
