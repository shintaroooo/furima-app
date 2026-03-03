<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab;
        $keyword = $request->keyword;

        //マイリスト
        if ($tab === 'mylist') {

            if (!Auth::check()) {
                $items = collect();
                return view('item.index', compact('items'));
            }
            $query = Auth::user()->likedItems();
    } else {
        $query = Item::query();
        //自分の出品は表示しない
        if(Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }
    }
    //検索機能（部分一致）
    if ($keyword) {
        $query->where('name', 'like', "%{$keyword}%");
    }
    $items = $query->latest()->get();
    return view('item.index', compact('items'));
    }

    public function show(Item $item_id)
    {
        $item = $item_id;
        $item->load([
            'images',
            'user',
            'categories',
            'comments.user',
            'likes',
            'purchase'
        ]);
        return view('item.detail', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        if ($item->purchase) {
            return back();
        }
        DB::transaction(function () use ($request, $item) {

            Purchase::create([
                'buyer_id' => Auth::id(),
                'item_id' => $item->id,
                'price' => $item->price,
                'payment_method' => $request->payment_method,
                'address_id' => Auth::user()->addresses()->first()->id,
            ]);
        });
        return redirect()->route('item.index');
}
}
