<?php

namespace Tests\Feature\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use App\Models\ItemImage;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 住所を登録すると購入画面に反映される()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);
        $user->address()->save($address);
        $user->refresh();

        //商品作成
        $item = Item::factory()->create();
        ItemImage::factory()->create([
            'item_id' => $item->id,
            'image_path' => 'test.jpg',
        ]);

        //購入画面にアクセス
        $response = $this->actingAs($user)->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee('東京都');
    }

    /** @test */
    public function 購入時に住所が紐づく()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $user->address()->save($address);
        $user->refresh();

        $item = Item::factory()->create();
        ItemImage::factory()->create([
            'item_id' => $item->id,
            'image_path' => 'test.jpg',
        ]);

        $response = $this->actingAs($user)->get("/purchase/success/{$item->id}");

        $response->assertRedirect(route('item.index'));

        $this->assertDatabaseHas('purchases', [
            'address_id' => $address->id,
        ]);
    }
}
