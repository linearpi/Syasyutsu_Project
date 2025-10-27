@extends('layouts.base_result')

@section('title','グラフ表示ページ')

@section('headder')
<div class="head w3-display-container w3-teal">
    <div class="w3-display-right">
        <h1>グラフ表示ページ</h1>
    </div>
    <div class="w3-display-left">
        <a href="/" style="text-decoration:none;">
            <p class="w3-sans-serif">LOGO&emsp;</p>
        </a>
    </div>
</div>
@endsection

@section('main')
<div class="w3-container" style="margin-top:20px;">

    <div class="w3-row-padding">
        @foreach (['height', 'length', 'width'] as $type)
            @php
                $filename = "{$year}_{$month}_{$day}_{$type}_graph.png";
                $path = asset('output_images/' . $filename);
            @endphp

            <div class="w3-third w3-margin-bottom">
                <div class="w3-card w3-round w3-white w3-hover-shadow" style="padding:15px; text-align:center;">
                    <h3 class="w3-text-teal">{{ ucfirst($type) }} グラフ</h3>
                    @if (File::exists(public_path('output_images/' . $filename)))
                        <a href="{{ $path }}?t={{ time() }}" data-lightbox="graphs" data-title="{{ ucfirst($type) }} グラフ">
                            <img src="{{ $path }}?t={{ time() }}" 
                                 alt="{{ $type }} グラフ" 
                                 style="max-width:100%; height:auto; border-radius:8px; cursor:pointer;">
                        </a>
                    @else
                        <p style="color:red;">{{ $type }} グラフが見つかりません</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

@section('bottom-links')
@include('app.partials.tab-styles')
<hr>
<a href="{{ url('/app/date-input') }}" class="back-link">🔧 生成ページへ戻る</a>
<br>
<a href="{{ url('/search/combined/all?q=all') }}" class="back-link">📄 統合ページへ戻る</a>
<br>
<a href="{{ url('/index') }}" class="back-link">🏠 トップページへ戻る</a>
@endsection

@push('styles')
<style>
/* Lightbox 画像をできるだけ大きく表示 */
.lb-image {
    max-width: 100% !important;
    max-height: 100% !important;
}
</style>
@endpush
