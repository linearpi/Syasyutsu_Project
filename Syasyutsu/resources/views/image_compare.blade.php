<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>画像圧縮比較一覧</title>
    <style>
        img {
            max-width: 300px;
            margin-bottom: 10px;
        }
        .image-block {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <h1>画像圧縮比較一覧</h1>

    <div class="image-block">
        <h2>オリジナル</h2>
        <img src="{{ $original }}" alt="Original Image"><br>
    </div>

    @foreach ($compressedImages as $img)
        <div class="image-block">
            <h2>圧縮 {{ $img['rate'] }}% 品質</h2>
            <img src="{{ $img['url'] }}" alt="Compressed {{ $img['rate'] }}%">
        </div>
    @endforeach
</body>
</html>
