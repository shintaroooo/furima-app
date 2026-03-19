<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function いいねできる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/like");
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function いいねを解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // いいねをする
        $user->likedItems()->attach($item->id);

        $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 未ログインユーザーはいいねできない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/like");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function いいね済みの場合は色が変わる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // いいねをする
        $item->likedUsers()->attach($user);
        $response = $this->actingAs($user)->get("/item/{$item->id}");

        //ピンクのハート画像が表示される
        $response->assertSee('hartlogo_pink.png');
        //デフォルトは表示されない
        $response->assertDontSee('hartlogo_default.png');
    }
}
