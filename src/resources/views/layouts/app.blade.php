<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'フリマアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>

<body>
    @if (Auth::check() && Auth::user()->hasVerifiedEmail())
        {{-- ログイン & メール認証済み --}}
        <header class="user-header">
            <div class="user-header__inner">
                <a href="{{ route('profile.index') }}" class="user-header__logo-link">
                    <img src="{{ asset('images/header_logo.png') }}" alt="COACHTECH ロゴ" class="user-header__logo">
                </a>

                <form action="{{ route('item.index') }}" method="GET" class="user-header__search-form">
                    {{-- タブの状態を維持して検索できるようにする --}}
                    @if (request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif
                    <input type="search" name="keyword" class="user-header__search-input" placeholder="なにをお探しですか？"
                        value="{{ request('keyword') }}">
                </form>

                <nav class="user-header__nav">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="user-header__nav-link user-header__nav-button">
                            ログアウト
                        </button>
                    </form>
                    <a href="{{ route('profile.index') }}" class="user-header__nav-link">マイページ</a>
                    <a href="#" class="user-header__sell-link">出品</a>
                </nav>
            </div>
        </header>

        <main class="user-content">
            @yield('content')
        </main>
    @else
        <header class="auth-header">
            <div class="auth-header__inner">
                <a href="/">
                    <img src="{{ asset('images/header_logo.png') }}" alt="COACHTECH ロゴ" class="auth-header__logo">
                </a>
            </div>
        </header>

        <main class="auth-content">
            <div class="form-wrapper">
                <h1 class="form-title">@yield('form-title')</h1>
                @yield('content')
                <div class="link">
                    @yield('link')
                </div>
            </div>
        </main>
    @endif
</body>

</html>
