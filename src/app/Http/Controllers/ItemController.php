<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\ItemImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;



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
    //出品
    public function create()
    {
        $categories = Category::all();
        return view('item.sell', compact('categories'));
    }

    //出品の保存
    public function store(ExhibitionRequest $request)
    {
        DB::transaction(function () use ($request) {
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
        ]);

        //カテゴリーの保存
        $item->categories()->attach($request->categories);

        //画像の保存
        if($request->hasFile('image')){
            $path = $request->file('image')->store('items', 'public');
            ItemImage::create([
                'item_id' => $item->id,
                'image_path' => $path,
        ]);
        }
    });
    return redirect()->route('item.index');
    }
}