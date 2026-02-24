<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => User::factory(), // ユーザーも自動生成
        'name' => $this->faker->word(),
        'description' => $this->faker->sentence(),
        'price' => $this->faker->numberBetween(1000, 20000),
        'brand' => $this->faker->company(),
        'condition' => $this->faker->randomElement([
            '良好',
            '目立った傷や汚れなし',
            'やや傷や汚れあり',
            '状態が悪い',
        ]),
        'status' => 'available',
    ];
    }
}
