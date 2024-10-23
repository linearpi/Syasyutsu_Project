<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
</head>
<body>
<h1>@yield('heading')</h1>

<hr size="1">

<div class="content1">
    @yield('content1')
</div>


<div class="content2">
    @yield('content2')
</div>

<div class="footer">
    @yield('footer')
</div>
</body>
</html>
