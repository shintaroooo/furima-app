@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('title', '認証画面')

@section('content')
    <div class="verify-wrapper">
        <p class="verify-message">
            登録していただいたメールアドレスに確認メールを送付しました。<br>
            メール認証を完了してください。
        </p>
        <div class="verify-actions">

            @if (session('status') == 'verification-link-sent')
                <p class="status-message">
                    認証メールを再送しました。
                </p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="resend-button">認証メールを再送する</button>
            </form>
        </div>
    </div>
@endsection
