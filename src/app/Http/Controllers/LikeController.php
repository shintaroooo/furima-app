<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item_id)
    {
        $item = $item_id;
        $user = Auth::user();

        if($user->likedItems()->where('item_id', $item->id)->exists()) {
            // 既にいいねしている場合は、いいねを解除
            $user->likedItems()->detach($item->id);
        } else {
            // いいねしていない場合は、いいねを追加
            $user->likedItems()->attach($item->id);
        }
        return back();
    }
}
