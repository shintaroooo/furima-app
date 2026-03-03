<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;

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

    public function store(PurchaseRequest $request, Item $item_id)
    {
        $item = $item_id;
        if($item->purchase) {
            return back();//自分の出品は購入できない
        }
        DB::transaction(function () use ($request, $item) {

            Purchase::create([
                'buyer_id' => Auth::id(),
                'item_id' => $item->id,
                'price' => $item->price,
                'payment_method' => $request->payment_method,
                'address_id' => $request->address_id,
            ]);
        });
        return redirect()->route('item.index');
}
}
