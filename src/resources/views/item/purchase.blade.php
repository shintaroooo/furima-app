@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <form action="{{ route('purchase.store', $item->id) }}" method="POST" class="purchase">
        @csrf
        {{-- 左：商品情報 --}}
        <div class="purchase-left">
            <div class="purchase-item">
                <img src="{{ asset('storage/' . $item->images->first()->image_path) }}">
                <div class="purchase-item__info">
                    <h2>{{ $item->name }}</h2>
                    <p class="purchase-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="purchase-section">
                <h3>支払い方法</h3>
                <select name="payment_method" id="payment-method">
                    <option value="">選択してください</option>
                    <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ支払い
                    </option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>カード支払い
                    </option>
                </select>
                @error('payment_method')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>
            <div class="purchase-section purchase-address">
                <h3>配送先</h3>
                <a class="address-edit" href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}">変更する</a>
                @if ($address)
                    <p>〒{{ $address->postal_code }}</p>
                    <p>{{ $address->address }}</p>
                    <p>{{ $address->building }}</p>
                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                @endif
                @error('address_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        {{-- 右エリア --}}
        <div class="purchase-right">
            <div class="purchase-summary">
                <div class="summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span id="payment-method-text">未選択</span>
                </div>
            </div>

            <button class="purchase-button">購入する</button>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const select = document.getElementById("payment-method");
            const display = document.getElementById("payment-method-text");

            select.addEventListener("change", function() {

                const selectedText = select.options[select.selectedIndex].text;

                if (select.value === "") {
                    display.textContent = "未選択";
                } else {
                    display.textContent = selectedText;
                }

            });

        });
    </script>
@endsection
