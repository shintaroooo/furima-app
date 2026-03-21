@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell-container">

        <h1 class="sell-title">商品の出品</h1>

        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- 商品画像 --}}
            <div class="form-section">
                <h3>商品画像</h3>

                <div class="image-upload">

                    <img id="image-preview" src="" alt="" class="image-preview">

                    <label class="image-upload__box">
                        <input type="file" name="image" id="image-input">
                        <span>画像を選択する</span>
                    </label>
                </div>
                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品の詳細 --}}
            <div class="form-section">
                <h3 class="section-title">商品の詳細</h3>

                <p class="form-label">カテゴリー</p>
                <div class="category-list">
                    @foreach ($categories as $category)
                        <label class="category-tag">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>


                <p class="form-label">商品の状態</p>
                <select name="condition" class="form-select">
                    <option value="" selected disabled>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
            </div>

            {{-- 商品名と説明 --}}
            <div class="form-section">
                <h3 class="section-title">商品名と説明</h3>

                <label>商品名</label>
                <input type="text" name="name" class="form-input">

                <label>ブランド名</label>
                <input type="text" name="brand" class="form-input">

                <label>商品の説明</label>
                <textarea name="description" class="form-textarea"></textarea>

                <label>販売価格</label>
                <input type="number" name="price" class="form-input">
            </div>

            <button type="submit" class="sell-button">出品する</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const input = document.getElementById("image-input");
            const preview = document.getElementById("image-preview");

            input.addEventListener("change", function() {

                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    }

                    reader.readAsDataURL(file);
                }

            });

        });
    </script>
@endsection
