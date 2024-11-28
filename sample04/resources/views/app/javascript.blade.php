<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>hello world</p>
    
    <script>
        
    var fn = function() {
        alert("10秒経過しました（" + i + "回目）");
        i++;
    };
    var tm = 5000;
    var i = 1;
    setInterval(fn,tm);
    </script>
</body>
</html>