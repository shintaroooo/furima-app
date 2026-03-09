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
        <header class="header header--user">
            <div class="header__inner">
                <a href="{{ route('item.index') }}" class="header__logo-link">
                    <img src="{{ asset('images/header_logo.png') }}" alt="COACHTECH ロゴ" class="header__logo">
                </a>

                <form action="{{ route('item.index') }}" method="GET" class="header__search">
                    {{-- タブの状態を維持して検索できるようにする --}}
                    @if (request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif
                    <input type="search" name="keyword" class="header__search-input" placeholder="なにをお探しですか？"
                        value="{{ request('keyword') }}">
                </form>
                <nav class="header__nav">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="header__link header__button">
                            ログアウト
                        </button>
                    </form>
                    <a href="{{ route('profile.index') }}" class="header__link">マイページ</a>
                    <a href="{{ route('item.create') }}" class="header__sell">出品</a>
                </nav>
            </div>
        </header>

        <main class="content">
            <h1 class="form-title">@yield('form-title')</h1>
            @if (session('success'))
                <div class="success">{{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    @else
        <header class="header header--auth">
            <div class="header__inner header__inner--center">
                <a href="/" class="header__logo-link">
                    <img src="{{ asset('images/header_logo.png') }}" alt="COACHTECH ロゴ" class="header__logo">
                </a>
                <form action="{{ route('item.index') }}" method="GET" class="header__search">
                    {{-- タブの状態を維持して検索できるようにする --}}
                    @if (request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif
                    <input type="search" name="keyword" class="header__search-input" placeholder="なにをお探しですか？"
                        value="{{ request('keyword') }}">
                </form>
                <nav class="header__nav">
                    <a href="{{ route('login') }}" class="header__link">ログイン</a>
                    <a href="{{ route('profile.index') }}" class="header__link">マイページ</a>
                    <a href="{{ route('item.create') }}" class="header__sell">出品</a>
                </nav>
            </div>
        </header>
        <main>
            @yield('content')
            <div class="link">
                @yield('link')
            </div>
        </main>
    @endif
</body>

</html>
