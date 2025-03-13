<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'favorite' => $this->faker->boolean(),
            'color' => $this->faker->safeColorName(),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
