<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'buyer_id' => User::factory(), // 購入者も自動生成
            'item_id' => Item::factory(), // アイテムも自動生成
            'price' => $this->faker->numberBetween(1000, 20000),
            'payment_method' => 'credit_card',
            'address_id' => null, // 住所は後で関連付けるため
        ];
    }
}
