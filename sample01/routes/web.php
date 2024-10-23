<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/000', function () {
    $html = <<<EOF
    <h1>hello world</h1>
    EOF;
    return $html;
});
!
Route::get('/001', function () {
    $html = "    
<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
    <h1>hello world!</h1>
    <input type='button' value='push me!'/>
</body>
</html>    
    ";
    return $html;
});
