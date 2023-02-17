<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>App</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- TODO: Remove this it's just for testing --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
        
        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        @vite('resources/js/app.js')
    </body>
</html>
