<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskUpdateTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_user_can_update_own_task(): void
    {
        $user   = $this->createMember();
        $task   = $this->createTask($user);
        $colors = $this->createTaskColors();

        $updateData = [
            'title'       => 'Título Atualizado',
            'description' => 'Descrição atualizada',
            'status'      => 'in_progress',
            'color_id'    => $colors['red']->id,
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'          => $task->id,
                    'title'       => $updateData['title'],
                    'description' => $updateData['description'],
                    'status'      => $updateData['status'],
                    'color'       => [
                        'id' => $colors['red']->id,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'title'  => $updateData['title'],
            'status' => $updateData['status'],
        ]);
    }

    public function test_admin_can_update_any_task(): void
    {
        $admin  = $this->createAdmin();
        $member = $this->createMember();
        $task   = $this->createTask($member);

        $updateData = [
            'title'  => 'Atualizado pelo Admin',
            'status' => 'completed',
        ];

        $response = $this->actingAs($admin)
            ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id'      => $task->id,
            'title'   => $updateData['title'],
            'status'  => $updateData['status'],
            'user_id' => $member->id, // O proprietário não deve mudar
        ]);
    }

    public function test_manager_can_update_any_task(): void
    {
        $manager = $this->createManager();
        $member  = $this->createMember();
        $task    = $this->createTask($member);

        $updateData = [
            'title'  => 'Atualizado pelo Gerente',
            'status' => 'completed',
        ];

        $response = $this->actingAs($manager)
            ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id'      => $task->id,
            'title'   => $updateData['title'],
            'status'  => $updateData['status'],
            'user_id' => $member->id, // O proprietário não deve mudar
        ]);
    }

    public function test_regular_member_cannot_update_others_task(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $task    = $this->createTask($member2);

        $updateData = [
            'title'  => 'Tentativa de Atualização',
            'status' => 'completed',
        ];

        $response = $this->actingAs($member1)
            ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(403); // Forbidden

        $this->assertDatabaseMissing('tasks', [
            'id'    => $task->id,
            'title' => $updateData['title'],
        ]);
    }

    public function test_regular_member_cannot_reassign_task(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $task    = $this->createTask($member1);

        $updateData = [
            'title'   => 'Tentativa de Reassinamento',
            'user_id' => $member2->id, // Tentando mudar o proprietário
        ];

        $response = $this->actingAs($member1)
            ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200); // A requisição é aceita

        // Mas o campo user_id deve ser ignorado
        $this->assertDatabaseHas('tasks', [
            'id'      => $task->id,
            'title'   => $updateData['title'],
            'user_id' => $member1->id, // Continua pertencendo ao membro1
        ]);
    }

    public function test_update_requires_validation(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $invalidData = [
            'title'    => str_repeat('a', 300), // título muito longo
            'status'   => 'invalid-status', // status inválido
            'color_id' => 9999, // cor que não existe
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/tasks/{$task->id}", $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status', 'color_id']);
    }

    public function test_returns_404_for_nonexistent_task_update(): void
    {
        $user = $this->createMember();

        $updateData = [
            'title' => 'Tarefa Inexistente',
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/tasks/99999", $updateData);

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_update_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $updateData = [
            'title' => 'Tentativa Não Autenticada',
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(401);
    }
}
