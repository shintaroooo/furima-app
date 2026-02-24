<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'postal_code' => '123-4567',
            'prefecture' => 'Tokyo',
            'city' => 'Shibuya',
            'street' => '1-1-1',
            'building' => 'Test Building',
        ];
    }
}
