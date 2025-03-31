<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\TaskColor;
use App\Models\User;
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
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'color_id'    => function () {
                return TaskColor::inRandomOrder()->first()?->id ?? 1;
            },
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
        ];
    }

    /**
     * Define uma tarefa como pendente.
     *
     * @return Factory
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    /**
     * Define uma tarefa como em andamento.
     *
     * @return Factory
     */
    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in_progress',
            ];
        });
    }

    /**
     * Define uma tarefa como concluída.
     *
     * @return Factory
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }

    /**
     * Define uma tarefa com uma cor específica.
     *
     * @param string $colorName O nome da cor (ex.: 'Vermelho', 'Azul')
     * @return Factory
     */
    public function withColor(string $colorName)
    {
        return $this->state(function (array $attributes) use ($colorName) {
            $colorId = TaskColor::where('name', $colorName)->first()?->id;

            return [
                'color_id' => $colorId,
            ];
        });
    }
}
