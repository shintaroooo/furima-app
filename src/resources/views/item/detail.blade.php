@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

{{-- @section('form-title', '商品詳細') --}}
@section('content')
    <div class="item-detail">

        {{-- 左：商品画像 --}}
        <div class="item-detail__left">
            @if ($item->images->isNotEmpty())
                <img class="item-detail__image" src="{{ asset('storage/' . $item->images->first()->image_path) }}">
            @endif
        </div>

        {{-- 右：商品情報 --}}
        <div class="item-detail__right">
            <h1 class="item-name">{{ $item->name }}</h1>
            <p class="item-brand">ブランド: {{ $item->brand }}</p>
            <p class="item-price"><span class="price-yen">¥</span>{{ number_format($item->price) }}
                <span class="price-tax">(税込)</span>
            </p>

            {{-- いいね数 --}}
            <div class="item-actions">
                @auth
                    <form action="{{ route('item.like', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="like-button" type="submit">

                            @if (auth()->user()->likedItems()->where('item_id', $item->id)->exists())
                                <img src="{{ asset('images/hartlogo_pink.png') }}">
                            @else
                                <img src="{{ asset('images/hartlogo_default.png') }}">
                            @endif
                            {{ $item->likes->count() }}
                        </button>
                    </form>
                @endauth

                <div class="comment-count">
                    <img src="{{ asset('images/chatlogo.png') }}" alt="コメントアイコン" class="comment-icon">
                    {{ $item->comments->count() }}
                </div>
            </div>

            {{-- 商品購入ボタン --}}
            @if (!$item->purchase && Auth::id() !== $item->user_id)
                <a href="{{ route('purchase.create', ['item_id' => $item->id]) }}">
                    <button class="purchase-button">購入手続きへ</button>
                </a>
            @endif
            @if ($item->purchase)
                <p style="color: red;">Sold</p>
            @endif

            {{-- 商品説明 --}}
            <div class="item-description">
                <h3>商品説明</h3>
                <p>{{ $item->description }}</p>
            </div>

            {{-- 商品の情報 --}}
            <div class="item-info">
                <h3>商品の情報</h3>
                <p>カテゴリー：</p>

                <div class="category-list">
                    @foreach ($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @endforeach
                </div>

                <p>商品の状態：{{ $item->condition }}</p>
            </div>

            {{-- コメント --}}
            <div class="item-comments">
                <h3>コメント({{ $item->comments->count() }})</h3>

                @foreach ($item->comments as $comment)
                    <p>{{ $comment->user->name }}: {{ $comment->comment }}</p>
                @endforeach

                @auth
                    <form action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <textarea name="comment" rows="4"></textarea>
                        <button type="submit" class="comment-button">コメントを送信する</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
