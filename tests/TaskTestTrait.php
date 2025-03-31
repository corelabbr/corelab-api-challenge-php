<?php

declare(strict_types = 1);

namespace Tests;

use App\Models\Task;
use App\Models\TaskColor;
use App\Models\User;

trait TaskTestTrait
{
    /**
     * Cria cores para tarefas
     */
    protected function createTaskColors(): array
    {
        $blue = TaskColor::firstOrCreate(
            ['name' => 'Azul'],
            [
                'hex_code'    => '#4285F4',
                'description' => 'Azul padrão para tarefas normais',
                'is_active'   => true,
            ]
        );

        $red = TaskColor::firstOrCreate(
            ['name' => 'Vermelho'],
            [
                'hex_code'    => '#FF5252',
                'description' => 'Vermelho vibrante para tarefas urgentes',
                'is_active'   => true,
            ]
        );

        return compact('blue', 'red');
    }

    /**
     * Cria uma tarefa para um usuário específico
     */
    protected function createTask(User $user, array $attributes = []): Task
    {
        $colors = $this->createTaskColors();

        return Task::factory()->create(array_merge([
            'user_id'  => $user->id,
            'color_id' => $colors['blue']->id,
        ], $attributes));
    }
}
