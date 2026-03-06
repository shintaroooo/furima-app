<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'description',
        'price',
        'condition',
    ];
    //出品者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //画像（1対N）
    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    //コメント（1対N）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //いいね（N対N）
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    //購入(1対1)
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    //カテゴリー（N対N）
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    //いいね数
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
}