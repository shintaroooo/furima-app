<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 全てのアイテムが表示される()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get('/');

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    /** @test */
    public function 購入済アイテムはsoldと表示される()
    {
        $item = Item::factory()->create([
            'status' => 'sold',
        ]);

        $response = $this->get('/');

        $response->assertSee('sold');
    }

    /** @test */
    public function 自分の出品商品は一覧に表示されない()
    {
        $user = User::factory()->create();
        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の出品商品',
        ]);

        Item::factory()->create([
            'name' => '他人の出品商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の出品商品');
    }

    /** @test */
    public function いいねした商品だけ表示される()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create([
            'name' => 'いいねした商品',
        ]);

        $notLikedItem = Item::factory()->create([
            'name' => 'いいねしてない商品',
        ]);

        $likedItem->likedUsers()->attach($user);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしてない商品');
    }

    /** @test */
    public function マイリストで購入済商品はsoldと表示される()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'status' => 'sold',
        ]);
        $item->likedUsers()->attach($user);
        $response = $this->actingAs($user)->get('/?tab=mylist');

         $response->assertSee($item->name);
         $response->assertSee('sold');
    }

}