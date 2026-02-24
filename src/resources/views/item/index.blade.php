@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('form-title', '商品一覧')

@section('content')

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
