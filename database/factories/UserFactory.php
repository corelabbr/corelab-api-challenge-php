<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'id_user' => $this->faker->unique()->numberBetween(1, 1000),
            'name' => $this->faker->name,
            'login' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
        ];
    }
}
