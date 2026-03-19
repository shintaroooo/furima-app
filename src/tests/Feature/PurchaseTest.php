<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 購入成功後にDBに保存される()
    {
        $user = User::factory()->create();

        Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $item = Item::factory()->create();
        $item->refresh(); // itemの状態を最新にする

        $response = $this->actingAs($user)->get("/purchase/success/{$item->id}");

        $this->actingAs($user)->get("/purchase/success/{$item->id}");
        $this->assertDatabaseHas('purchases', [
            'buyer_id' => $user->id,
            'item_id' => $item->id,
            'price' => $item->price,
        ]);
    }

    /** @test */
    public function 購入後は商品がsoldになる()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create([
            'status' => 'available',
        ]);

        $this->actingAs($user)->get("/purchase/success/{$item->id}");

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品はプロフィールの購入一覧に表示される()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create([
            'name' => 'iPhone16',
        ]);

        // 購入
        $this->actingAs($user)->get("/purchase/success/{$item->id}");

        //マイページ表示
        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertSee('iPhone16');
    }

    /** @test */
    public function クレジットカードを選択して購入できる()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        //successでDB保存
        $this->actingAs($user)->get("/purchase/success/{$item->id}");

        $this->assertDatabaseHas('purchases', [
            'payment_method' => 'credit_card',
        ]);
    }

    /** @test */
    public function コンビニを選択して購入できる()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create();

        //successでDB保存
        purchase::factory()->create([
            'buyer_id' => $user->id,
            'item_id' => $item->id,
            'price' => $item->price,
            'payment_method' => 'convenience',
            'address_id' => $address->id,
        ]);

        $this->assertDatabaseHas('purchases', [
            'payment_method' => 'convenience',
        ]);
    }
}

