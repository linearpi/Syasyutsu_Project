<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('/css/style_monitor.css') }}">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        <!-- p-l-c-monitor.blade.phpで定義したアプリが動作する。 -->
        {{ $slot }}
    </body>
</html>
