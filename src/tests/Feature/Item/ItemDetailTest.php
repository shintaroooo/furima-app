<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 15000,
            'condition' => '良好',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('テスト説明');
        $response->assertSee('15,000');
        $response->assertSee('良好');
    }

    /** @test */
    public function 複数カテゴリが表示される()
    {
        $item = Item::factory()->create();

        $categories = \App\Models\Category::factory()->count(2)->create();
        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get("/item/{$item->id}");
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
