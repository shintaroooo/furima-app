<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $page = $request->page ?? 'sell';

        // 出品商品
        $sellItems = $user->items()->with('images')->latest()->get();
        // 購入商品
        $buyItems = $user->purchases()->with('item.images')->latest()->get();

        return view('profile.index', compact('user', 'sellItems', 'buyItems', 'page'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    // プロフィール情報更新処理
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        //プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        // ユーザー情報の更新
        $user->update([
            'name' => $request->name,
        ]);

        // 住所情報の更新
        $address = $user->address ?: new Address();
        $address->fill([
            'user_id' => $user->id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        $address->save();

        return redirect()->route('item.index')->with('success', 'プロフィールを更新しました');
    }
}
