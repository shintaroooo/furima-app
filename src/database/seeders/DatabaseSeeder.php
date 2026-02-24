<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Purchase;
use App\Models\Address;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CategorySeeder::class]);

        User::factory(5)->create(); //ユーザーを5人作成

        Item::factory(10)->create()->each(function ($item) {

            $categoryIds = Category::inRandomOrder()->take(rand(1,3))->pluck('id'); //ランダムに1-3カテゴリを選択
            $item->categories()->attach($categoryIds); //アイテムにカテゴリを紐付け

            //各アイテムに1枚の画像を作成
            ItemImage::factory()->create(['item_id' => $item->id]);

            //50%の確率で売却済みにする
            if(rand(0,1)) {
                $buyer = User::inRandomOrder()->first(); //ランダムな購入者を選択
                $address = Address::factory()->create(['user_id' => $buyer->id]); //購入者の住所を作成
                Purchase::factory()->create([
                    'item_id' => $item->id,
                    'buyer_id' => $buyer->id,
                    'price' => $item->price,
                    'address_id' => $address->id,
                ]);
            }

        });
    }
}
