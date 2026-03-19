<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function create(Item $item_id)
    {
        $item = $item_id;
        if ($item->purchase) {
            return redirect()->route('item.detail', $item);
        }
        if($item->user_id === Auth::id()) {
            return redirect()->route('item.detail', $item);
        }
        // dd(Auth::id(), auth()->user()->address); //

        $address = auth()->user()->address;
        return view('item.purchase', compact('item', 'address'));
    }

    //購入処理
    public function store(PurchaseRequest $request, Item $item_id)
    {
        $item = $item_id;

        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentMethod = $request->payment_method === 'convenience' ? ['konbini'] : ['card'];

        $session = Session::create([
            'payment_method_types' => $paymentMethod,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $item->id]),
            'cancel_url' => route('item.detail', ['item_id' => $item->id]),
        ]);
        return redirect($session->url);
    }

    public function success(Item $item_id)
    {
        $item = $item_id;
    if($item->purchase()->exists()) {
        return redirect()->route('item.index');
    }

    Purchase::create([
        'buyer_id' => Auth::id(),
        'item_id' => $item->id,
        'price' => $item->price,
        'payment_method' => 'credit_card',
        'address_id' => Auth::user()->address->id,
    ]);

    return redirect()->route('item.index')->with('success', '購入が完了しました');
    }

}
