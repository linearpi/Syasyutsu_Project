<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/style_result.css') }}">
</head>
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