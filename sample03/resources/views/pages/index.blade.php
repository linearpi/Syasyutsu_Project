@extends('layouts.base')

@section('title',"画像保存")

@section('heading',"画像保存")

@section('content1')
<h4>img_storeに送信</h4>
<h5>投稿した画像を保存せずに表示する</h5>
<form action="http://192.168.11.12:8000/img_store" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">Product Title:</label>
    <input type="text" name="title" id="title">

    <label for="image">Image:</label>
    <input type="file" name="image" id="image">

    <button type="submit">Submit</button>
</form>
@endsection

@section('content2')
<hr size="1">
<h4>img_createに送信</h4>
<h5>DBに保存</h5>
@if( count($errors) > 0 )
<ul>
	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>
@endif

<form action="http://192.168.11.12:8000/img_create" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">Product Title:</label>
    <input type="text" name="title" id="title">

    <label for="image">Image:</label>
    <input type="file" name="image" id="image">

    <button type="submit">Submit</button>
</form>
@endsection
