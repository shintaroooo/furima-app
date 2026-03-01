<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['images', 'purchase']);

        //マイリスト
        if ($request->tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
            } else {
                $items = Auth::user()->likedItems()->with(['images', 'purchase'])->latest()->get();
        }
    } else {
        //自分の出品は表示しない
        if(Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }
        $items = $query->latest()->get();
    }
        return view('item.index', compact('items'));
    }

    public function show(Item $item)
    {
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
}
