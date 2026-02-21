@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('form-title', '商品一覧')

@section('content')
    <div class="item-container">
        @foreach ($items as $item)
            <div class="item-card">
                <a href="{{ route('item.show', $item->id) }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            </div>
        @endforeach
    </div>
