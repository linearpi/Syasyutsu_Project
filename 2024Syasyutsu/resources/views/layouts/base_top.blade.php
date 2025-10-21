<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/style_top.css') }}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
<body>
    <div class="headder">
        @yield("headder")
    </div>

    <div class="main">
        @yield("main")
    </div>

    <div class="footer">
        @yield("footer")
    </div>
</body>
</html>