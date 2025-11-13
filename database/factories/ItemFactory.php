<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->word(),
            'status' => $this->faker->randomElement(['lost', 'found']),
            'city' => $this->faker->city(),
            'user_id' => User::factory(),
        ];
    }
}
