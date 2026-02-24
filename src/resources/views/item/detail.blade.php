@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('form-title', '商品詳細')
@section('content')
    <h1>{{ $item->name }}</h1>
    {{--  画像 --}}
    @if ($item->images->isNotEmpty())
        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" width="300">
    @endif
    <p>ブランド：{{ $item->brand }}</p>
    <p>¥{{ number_format($item->price) }}(税込)</p>

    {{-- いいね数 --}}
    <p>いいね数：{{ $item->likes->count() }}</p>

    {{-- コメント数 --}}
    <p>コメント数：{{ $item->comments->count() }}</p>

    @if ($item->purchase)
        <p style="color: red;">Sold</p>
    @endif

    <hr>

    <h3>商品説明</h3>
    <p>{{ $item->description }}</p>

    <hr>
    <h3>商品の情報</h3>
    <p>カテゴリー：</p>
    @foreach ($item->categories as $category)
        {{ $category->name }}
    @endforeach
    </p>
    <p>商品の状態：</p>

    <hr>

    <h3>コメント({{ $item->comments->count() }})</h3>
    @foreach ($item->comments as $comment)
        <p>{{ $comment->user->name }}: {{ $comment->comment }}</p>
    @endforeach
@endsection
