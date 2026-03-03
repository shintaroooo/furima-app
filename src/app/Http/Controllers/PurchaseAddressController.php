<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class PurchaseAddressController extends Controller
{
    public function edit(Item $item_id)
    {
        $item = $item_id;
        //住所
        $address = Auth::user()->address;
        return view('address', compact('item', 'address'));
    }

    public function update(AddressRequest $request, Item $item_id)
    {
        $item = $item_id;

        $user = Auth::user();
        // 住所が無ければ新規作成、あれば更新
        $address = $user->address ?: new Address(['user_id' => $user->id]);

        $address->fill([
            'user_id'     => $user->id,
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        $address->save();

        return redirect()
            ->route('purchase.create', ['item_id' => $item->id])
            ->with('success', '送付先住所を更新しました');
    }
}

