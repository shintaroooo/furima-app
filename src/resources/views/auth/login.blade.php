@extends('layouts.app')

@section('title', 'ログイン')
@section('css')
@endsection

@section('form-title', 'ログイン')

@section('content')
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email">
        </div>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password">
        </div>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="submit-button">ログインする</button>
    </form>
@endsection

@section('link')
    <a href="{{ route('register') }}">会員登録はこちら</a>
@endsection
