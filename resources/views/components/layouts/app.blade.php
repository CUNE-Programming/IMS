<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @livewireStyles
        @livewireScripts
        <title>{{ $title ?? env('APP_NAME') }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
