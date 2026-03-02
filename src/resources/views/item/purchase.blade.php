@extends('layouts.app')

@section('content')
    <div class="purchase">

        <div class="purchase__left">
            <div class="purchase__item">
                <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" width="150">
            </div>
            <h2>{{ $item->name }}</h2>
            <p>¥{{ number_format($item->price) }}</p>
        </div>

        <form action="{{ route('purchase.store', $item->id) }}" method="POST">
            @csrf

            <h3>支払い方法</h3>
            <select name="payment_method">
                <option value="">選択してください</option>
                <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>カード支払い</option>
            </select>
            @error('payment_method')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <h3>配送先</h3>
            @if ($address)
                <p>〒{{ $address->postal_code }}</p>
                <p>{{ $address->city }}{{ $address->street }}</p>
                <input type="hidden" name="address_id" value="{{ $address->id }}">
            @else
                <p>住所が登録されていません</p>
            @endif

            @error('address_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <button type="submit">購入する</button>
        </form>
    </div>
@endsection
