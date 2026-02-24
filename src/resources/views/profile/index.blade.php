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
            <button class="tab active" data-tab="sell">出品した商品</button>
            <button class="tab" data-tab="buy">購入した商品</button>
        </div>
        <div id="sell" class="tab-content active">
            @foreach ($sellProducts ?? [] as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="product-image">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>

        <div id="buy" class="tab-content">
            @foreach ($buyProducts ?? [] as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="product-image">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const tabs = document.querySelectorAll(".tab");
        const sections = document.querySelectorAll(".product-section");

        tabs.forEach(tab => {
            tab.addEventListener("click", function() {

                // タブのactive切り替え
                tabs.forEach(t => t.classList.remove("active"));
                this.classList.add("active");

                // 商品表示切り替え
                sections.forEach(section => {
                    section.classList.remove("active");
                });

                document.getElementById(this.dataset.tab).classList.add("active");
            });
        });

    });
</script>
