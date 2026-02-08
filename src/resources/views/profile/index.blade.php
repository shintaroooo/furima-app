@extends('layouts.app')

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
            <a href="#" class="tab active">出品した商品</a>
            <a href="#" class="tab">購入した商品</a>
        </div>

        <div class="product-list">
            {{-- 商品カードを繰り返し表示（出品 or 購入） --}}
            @foreach ($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" class="product-image">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
