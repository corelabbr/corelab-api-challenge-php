<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private array $colorOptions = ['bg-[#BAE2FF]', 'bg-[#B9FFDD]', 'bg-[#FFE8AC]', 'bg-[#FFCAB9]',
        'bg-[#F99494]', 'bg-[#9DD6FF]', 'bg-[#ECA1FF]', 'bg-[#DAFF8B]',
        'bg-[#FFA285]', 'bg-[#CDCDCD]', 'bg-[#979797]', 'bg-[#A99A7C]'];

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'background_color' => $this->faker->randomElement($this->colorOptions),
            'is_favorite' => $this->faker->boolean
        ];
    }
}
