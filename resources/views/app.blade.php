<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Queue</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- TODO: Remove this it's just for testing --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
        
        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=DM+Serif+Display&display=swap" rel="stylesheet">

        {{-- CSS --}}
        @vite('resources/css/app.css')
    </head>
    <body class="bg-black">
        <div id="app">
            <app></app>
        </div>

        {{-- JS --}}
        @vite('resources/js/app.js')
    </body>
</html>
