@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

{{-- @section('form-title', 'プロフィール画面') --}}

@section('content')
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image-area">
                @if (Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像" class="profile-image">
                @else
                    <div class="default-profile-image"></div>
                @endif
            </div>
            <div class="profile-info">
                <h2 class="username">{{ Auth::user()->name }}</h2>
                <a href="{{ route('profile.edit') }}" class="edit-button">プロフィールを編集</a>
            </div>
        </div>

        {{-- タブ切り替え --}}
        <div class="tabs">
            <a href="{{ route('profile.index', ['page' => 'sell']) }}"
                class="tabs__link {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="{{ route('profile.index', ['page' => 'buy']) }}"
                class="tabs__link {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
        </div>

        {{-- 出品した商品 --}}
        @if ($page === 'sell')
            <div class="item-grid">
                @foreach ($sellItems as $item)
                    <a href="{{ route('item.detail', $item) }}" class="item-card">
                        <div class="item-card__image">
                            @if ($item->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                    class="product-image">
                            @endif

                            @if ($item->purchase)
                                <span class="item-card__sold">Sold</span>
                            @endif
                        </div>
                        <p class="item-card__name">{{ $item->name }}</p>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- 購入した商品 --}}
        @if ($page === 'buy')
            <div class="item-grid">
                @foreach ($buyItems as $purchase)
                    <a href="{{ route('item.detail', $purchase->item) }}" class="item-card">

                        <div class="item-card__image">
                            @if ($purchase->item->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $purchase->item->images->first()->image_path) }}">
                            @endif
                        </div>
                        <p class="item-card__name">{{ $purchase->item->name }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
