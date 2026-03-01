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
    @auth
        <form action="{{ route('item.like', $item->id) }}" method="POST">
            @csrf
            <button type="submit" style="border:none; background:none; color:blue; cursor:pointer;">
                @if (auth()->user()->likedItems()->where('item_id', $item->id)->exists())
                    <img src="{{ asset('images/hartlogo_pink.png') }}" width="30">
                @else
                    <img src="{{ asset('images/hartlogo_default.png') }}" width="30">
                @endif
                {{ $item->likes->count() }}
            </button>
        </form>
    @endauth

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
    <p>商品の状態：{{ $item->condition }}</p>

    <hr>

    <h3>コメント({{ $item->comments->count() }})</h3>
    @foreach ($item->comments as $comment)
        <p>{{ $comment->user->name }}: {{ $comment->comment }}</p>
    @endforeach
    {{-- コメント投稿フォーム --}}
    @auth
        <form action="{{ route('comment.store', $item->id) }}" method="POST">
            @csrf
            <textarea name="comment" rows="4"></textarea>
            <button type="submit">コメントを送信する</button>
        </form>
    @endauth
@endsection
