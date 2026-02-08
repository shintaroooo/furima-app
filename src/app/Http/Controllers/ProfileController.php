<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = collect();

        return view('profile.index', compact('user', 'products'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    // プロフィール情報更新処理
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        $user->fill($request->only(['name']));
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました');
    }
}
