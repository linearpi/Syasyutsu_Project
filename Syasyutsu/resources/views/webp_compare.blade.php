<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WebP 可逆圧縮 比較</title>
    <style>
      img { max-width: 45%; margin: 1%; vertical-align: top; }
    </style>
</head>
<body>
    <h1>WebP（可逆） 圧縮比較</h1>

    <div>
      <h2>オリジナル (PNG)</h2>
      <img src="{{ $original }}" alt="Original PNG">
    </div>

    <div>
      <h2>変換後 (WebP lossless)</h2>
      <img src="{{ $webp }}" alt="Lossless WebP">
    </div>
</body>
</html>
