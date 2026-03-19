<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;


class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 商品名で部分一致検索できる()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create([
            'name' => 'iPhone16',
        ]);

        $user->likedItems()->attach($likedItem->id);
        $response = $this->actingAs($user)->get('/?keyword=iPhone');

        $response->assertSee('iPhone16');
    }

    /** @test */
    public function 検索キーワードがマイリストでも保持される()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create([
            'name' => 'iPhone16',
        ]);

        $user->likedItems()->attach($likedItem->id);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=iPhone');

        $response->assertSee('iPhone16');
    }
}
