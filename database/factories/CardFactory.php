<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => User::factory(),
            'color' => $this->faker->safeColorName(),
            'content' => $this->faker->paragraph(),
            'title' => $this->faker->sentence(),
            'favorite' => $this->faker->boolean(),
        ];
    }
}
