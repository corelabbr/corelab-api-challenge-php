<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodoItem>
 */
class TodoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'completed' => false,
            'favorite' => false,
            'description' => $this->faker->paragraph,
            'color' => $this->faker->hexColor,
            'due_date' => null,
            'completed_at' => null,
            'user_id' => 1,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => true,
            'completed_at' => now(),
        ]);
    }

    public function favorite(): static
    {
        return $this->state(fn (array $attributes) => [
            'favorite' => true,
        ]);
    }

    public function withUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
        ]);
    }

    public function withDueDate(string $dueDate): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => $dueDate,
        ]);
    }

    public function withCompletedAt(string $completedAt): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => $completedAt,
        ]);
    }

    public function withColor(string $color): static
    {
        return $this->state(fn (array $attributes) => [
            'color' => $color,
        ]);
    }

    public function withDescription(string $description): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => $description,
        ]);
    }

    public function withTitle(string $title): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
        ]);
    }
}
