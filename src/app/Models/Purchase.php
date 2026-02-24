<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'buyer_id',
        'price',
        'payment_method',
        'address_id',
    ];

    //アイテム
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    //購入者
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    //住所
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}