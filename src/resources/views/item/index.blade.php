@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('form-title', '商品一覧')

@section('content')

    {{-- タブ切り替え --}}
    <div class="item-tabs">
        <a href="{{ route('item.index', ['keyword' => request('keyword')]) }}" class="item-tabs__link {{{ request('tab') !== 'mylist' ? 'active' : '' }}}">おすすめ</a>
        <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}" class="item-tabs__link {{{ request('tab') === 'mylist' ? 'is-active' : '' }}}">マイリスト</a>
    </div>
    @foreach ($items as $item)
        <div>
            <a href="{{ route('item.detail', $item) }}">
                <p>{{ $item->name }}</p>

                @if ($item->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" width="150">
                @endif

                @if ($item->purchase)
                    <span style="color: red;">Sold</span>
                @endif
            </a>
        </div>
    @endforeach
@endsection
