<!DOCTYPE HTML>
<html>
<head>
	<meta charset="urf-8">
	<title>Upload Page</title>
</head>
<body>
	<h1>画像を投稿する</h1>
<form action="http://192.168.11.12:8000/store" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name">
    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>
    <label for="image">Image:</label>
    <input type="file" name="image" id="image">
    <button type="submit">Submit</button>
</form>
</body>
</html>
