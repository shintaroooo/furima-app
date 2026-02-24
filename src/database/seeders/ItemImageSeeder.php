<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemImage;
use App\Models\Item;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::first(); //最初のアイテムを取得
        ItemImage::create([
            'item_id' => $item->id,
            'image_path' => 'Armani+Mens+Clock.jpg',
        ]);
    }
}
