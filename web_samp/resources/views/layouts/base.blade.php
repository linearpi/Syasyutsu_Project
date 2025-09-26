<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body>
<h1>@yield('heading')</h1>

<hr size="1">

<div class="errors">
	@yield('errors')
</div>

<div class="head-links">
    @yield('head-links')  
</div>

<div class="content1">
    @yield('content1')
</div>


<div class="content2">
    @yield('content2')
</div>

<div class="bottom-links">
    @yield('bottom-links')  
</div>

<div class="footer">
    @yield('footer')
</div>
</body>
</html>
