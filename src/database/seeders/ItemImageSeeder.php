<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemImage;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            'items/watch.jpg',
            'items/hdd.jpg',
            'items/onion.jpg',
            'items/shoes.jpg',
            'items/laptop.jpg',
            'items/mic.jpg',
            'items/bag.jpg',
            'items/tumbler.jpg',
            'items/coffee_grinder.jpg',
            'items/makeup.jpg',
        ];
        foreach ($images as $index => $image) {
            ItemImage::create([
                'item_id' => $index + 1,
                'image_path' => $image
            ]);
        }
    }
}
