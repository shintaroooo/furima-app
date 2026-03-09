<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); //最初のユーザーを取得
        $items =[
            [
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ時計',
            'condition' => '良好',
        ],
        [
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'condition' => '目立った傷や汚れなし',
        ],
        [
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition' => 'やや傷や汚れあり',
        ],
        [
            'name' => '革靴',
            'price' => 4000,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'condition' => '状態が悪い',
        ],
        [
            'name' => 'ノートPC',
            'price' => 45000,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'condition' => '良好',
        ],
        [
            'name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'description' => '高品質のレコーディング用マイク',
            'condition' => '目立った傷や汚れなし',
        ],
        [
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'condition' => 'やや傷や汚れあり',
        ],
        [
            'name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'condition' => '状態が悪い',
        ],
        [
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'condition' => '良好',
        ],
        [
            'name' => 'メイクセット',
            'price' => 2500,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'condition' => '目立った傷や汚れなし',
        ]
        ];
        foreach ($items as $item) {
            Item::create([
                'user_id' => $user->id, //ユーザーIDを設定
                'name' => $item['name'],
                'price' => $item['price'],
                'brand' => $item['brand'],
                'description' => $item['description'],
                'condition' => $item['condition'],
            ]);
        }
    }
}

