<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function プロフィールページが表示される()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
    }

    /** @test */
    public function プロフィール情報が更新できる()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/mypage/profile', [
            'name' => '更新ユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷ビル',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '更新ユーザー',
        ]);
    //住所も確認
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'address' => '東京都渋谷区',
        ]);
    }

    /** @test */
    public function プロフィールに出品商品と購入商品が表示される()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',]);

         $user->address()->save($address);

        //出品商品
         $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        //購入商品
         $item = Item::factory()->create([
            'name' => '購入商品',
        ]);

        //購入処理
        $this->actingAs($user)->get("/purchase/success/{$item->id}");

        //マイページ（購入一覧）
        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertSee('購入商品');
    }
}