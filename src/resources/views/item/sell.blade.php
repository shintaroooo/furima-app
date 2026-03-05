@extends('layouts.app')
@section('content')
    <h1>商品の出品</h1>
    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h3>商品画像</h3>
        <input type="file" name="image">
        @error('image')
            <p>{{ $message }}</p>
        @enderror

        <h3>カテゴリー</h3>
        @foreach ($categories as $category)
            <label>
                <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                {{ $category->name }}
            </label>
        @endforeach

        <h3>商品の状態</h3>
        <select name="condition">
            <option value="" selected disabled>選択してください</option>
            <option value="良好">良好</option>
            <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            <option value="状態が悪い">状態が悪い</option>
        </select>

        <h3>商品名</h3>
        <input type="text" name="name">

        <h3>ブランド名</h3>
        <input type="text" name="brand">

        <h3>商品の説明</h3>
        <textarea name="description"></textarea>

        <h3>販売価格</h3>
        <input type="number" name="price">

        <button type="submit">出品する</button>
    </form>
@endsection
