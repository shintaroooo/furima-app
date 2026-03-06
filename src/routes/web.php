<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

// 認証案内画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール内リンククリック時
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('profile.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 会員登録
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ログイン
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ログイン後画面
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// 住所の変更
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/purchase/address/{item_id}', [PurchaseAddressController::class, 'edit'])->name('purchase.address.edit');
    Route::patch('/purchase/address/{item_id}', [PurchaseAddressController::class, 'update'])->name('purchase.address.update');
});

// 商品一覧
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.detail');

//コメントの保存
Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');

//いいねの保存
Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('item.like');

//購入
Route::get('/purchase/{item_id}', [App\Http\Controllers\PurchaseController::class, 'create'])->middleware('auth')->name('purchase.create');
Route::post('/purchase/{item_id}', [App\Http\Controllers\PurchaseController::class, 'store'])->middleware('auth')->name('purchase.store');
//決済成功
Route::get('/purchase/success/{item_id}', [App\Http\Controllers\PurchaseController::class, 'success'])->middleware('auth')->name('purchase.success');

//出品
Route::get('/sell', [ItemController::class, 'create'])->middleware('auth')->name('item.create');
Route::post('/sell', [ItemController::class, 'store'])->middleware('auth')->name('item.store');