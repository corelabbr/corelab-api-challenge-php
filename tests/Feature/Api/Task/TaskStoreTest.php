<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskStoreTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_authenticated_user_can_create_task(): void
    {
        $user   = $this->createMember();
        $colors = $this->createTaskColors();

        $taskData = [
            'title'       => 'Nova Tarefa de Teste',
            'description' => 'Descrição da tarefa de teste',
            'color_id'    => $colors['blue']->id,
            'due_date'    => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title'       => $taskData['title'],
                    'description' => $taskData['description'],
                    'color'       => [
                        'id' => $colors['blue']->id,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'title'   => $taskData['title'],
            'user_id' => $user->id,
        ]);
    }

    public function test_regular_member_cannot_create_task_for_another_user(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $colors  = $this->createTaskColors();

        $taskData = [
            'title'       => 'Tarefa Inválida',
            'description' => 'Esta tarefa não deve ser criada para outro usuário',
            'color_id'    => $colors['blue']->id,
            'user_id'     => $member2->id, // Tenta especificar outro usuário
        ];

        $response = $this->actingAs($member1)
            ->postJson('/api/tasks', $taskData);

        $response->assertStatus(201); // A requisição é aceita

        // Mas a tarefa deve pertencer ao usuário que fez a requisição, não ao membro2
        $this->assertDatabaseHas('tasks', [
            'title'   => $taskData['title'],
            'user_id' => $member1->id, // A tarefa pertence ao membro1, não ao membro2
        ]);

        $this->assertDatabaseMissing('tasks', [
            'title'   => $taskData['title'],
            'user_id' => $member2->id,
        ]);
    }

    public function test_task_creation_requires_validation(): void
    {
        $user = $this->createMember();

        $invalidData = [
            'title'       => '', // título vazio
            'description' => str_repeat('a', 1000), // descrição muito longa
            'status'      => 'invalid-status', // status inválido
            'color_id'    => 9999, // cor que não existe
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/tasks', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status', 'color_id']);
    }

    public function test_unauthenticated_user_cannot_create_task(): void
    {
        $colors = $this->createTaskColors();

        $taskData = [
            'title'    => 'Tarefa Não Autorizada',
            'color_id' => $colors['blue']->id,
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(401);
    }
}
