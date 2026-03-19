<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function ログインユーザーはコメントできる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => 'テストコメント',
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

    /** @test */
    public function 未ログインユーザーはコメントできない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'テストコメント',
        ]);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function コメント未入力はバリデーションエラー()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => '',
        ]);
        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function コメントが255文字を超える場合はバリデーションエラー()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('a', 256);

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => $longComment,
        ]);
        $response->assertSessionHasErrors('comment');
    }
}
