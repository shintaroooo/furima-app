@extends('layouts.app')

@section('title', '住所の変更')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('form-title', '住所の変更')

@section('content')
    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}">
            @error('postal_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" value="{{ old('address', $address->address ?? '') }}">
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building', $address->building ?? '') }}">
            @error('building')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="submit-button">更新する</button>
    </form>
@endsection
