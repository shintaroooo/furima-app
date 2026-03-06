@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('form-title', 'プロフィール画面')

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

        <div class="tab-menu">
            <a href="{{ route('profile.index', ['page' => 'sell']) }}"
                class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="{{ route('profile.index', ['page' => 'buy']) }}"
                class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
        </div>
        @if ($page === 'sell')
            <div class="tab-content">
                @foreach ($sellItems as $item)
                    <div class="product-card">
                        @if ($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="product-image">
                        @endif
                        <p class="product-name">{{ $item->name }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($page === 'buy')
            <div class="tab-content">
                @foreach ($buyItems as $purchase)
                    <div class="product-card">
                        @if ($purchase->item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $purchase->item->images->first()->image_path) }}"
                                class="product-image">
                        @endif
                        <p class="product-name">{{ $purchase->item->name }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
