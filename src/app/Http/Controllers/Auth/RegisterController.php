<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 会員登録画面表示
    public function create()
    {
        return view('auth.register');
    }

    // 会員登録処理
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        // イベント発火
        event(new Registered($user));

        // ログイン状態にする
        Auth::login($user);

        // マイページへリダイレクト
        return redirect()->route('profile.index');
    }
}
