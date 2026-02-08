@extends('layouts.app')

@section('title', '住所の変更')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('form-title', '住所の変更')

@section('content')
    <form action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code">
            @error('postal_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address">
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" name="building_name">
            @error('building_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="submit-button">更新する</button>
    </form>
@endsection
