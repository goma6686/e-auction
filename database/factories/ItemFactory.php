<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'title' => $this->faker->words(3, true), //true - string returned instead of array
            'description' => $this->faker->paragraph(),
            'condition_id' => $this->faker->numberBetween(1,6),
            'category_id' => $this->faker->numberBetween(1,8),
            'user_id' => $this->faker->UUID(),
            'current_price' => $this->faker->randomFloat(4, 0, 1000),
        ];
    }
}
