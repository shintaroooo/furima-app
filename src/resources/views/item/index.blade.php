@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('form-title', '商品一覧')

@section('content')

    <div class="page-container">

        {{-- タブ切り替え --}}
        <div class="tabs">
            <a href="{{ route('item.index', ['keyword' => request('keyword')]) }}"
                class="tabs__link {{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
            <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
                class="tabs__link {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
        </div>

        {{-- 商品一覧 --}}
        <div class="item-grid">
            @foreach ($items as $item)
                <a href="{{ route('item.detail', $item) }}" class="item-card">
                    <div class="item-card__image">

                        @if ($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}">
                        @endif

                        @if ($item->status === 'sold' || $item->purchase)
                            <span class="item-card__sold">sold</span>
                        @endif
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
