@extends('layouts.app')

@section('title', 'プロフィール設定')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('form-title', 'プロフィール設定')

@section('content')

    <div class="edit-container">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- プロフィール画像 --}}
            <div class='edit-image'>
                <div class="profile_image_preview">
                    <img id="preview"
                        src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default_profile.png') }}">
                </div>
                <label for="profile_image" class="btn-select-image">画像を選択する</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;">
            </div>
            @error('profile_image')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- ユーザー名 --}}
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}">
            </div>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 郵便番号 --}}
            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code"
                    value="{{ old('postal_code', Auth::user()->address->postal_code ?? '') }}">
            </div>
            @error('postal_code')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 住所 --}}
            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" value="{{ old('address', Auth::user()->address->address ?? '') }}">
            </div>
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 建物名 --}}
            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" value="{{ old('building', Auth::user()->address->building ?? '') }}">
            </div>
            @error('building')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 更新ボタン --}}
            <button type="submit" class="submit-button">更新する</button>
        </form>
    </div>
    <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(event) {
                document.getElementById('preview').src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    </script>
@endsection
