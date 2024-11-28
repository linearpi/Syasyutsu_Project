<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        <h1>Hello World</h1>
        <!-- counter.blade.phpで定義したアプリが動作する。 -->
        {{ $slot }}
    </body>
</html>
