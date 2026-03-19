<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function ログアウトできる()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');
        $this->assertGuest();

        $response->assertRedirect('/login');

    }
}
