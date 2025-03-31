<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskDeleteTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_user_can_delete_own_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $response = $this->actingAs($user)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204); // No content

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_admin_can_delete_any_task(): void
    {
        $admin  = $this->createAdmin();
        $member = $this->createMember();
        $task   = $this->createTask($member);

        $response = $this->actingAs($admin)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_manager_can_delete_any_task(): void
    {
        $manager = $this->createManager();
        $member  = $this->createMember();
        $task    = $this->createTask($member);

        $response = $this->actingAs($manager)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_regular_member_cannot_delete_others_task(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $task    = $this->createTask($member2);

        $response = $this->actingAs($member1)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(403); // Forbidden

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_returns_404_for_nonexistent_task_delete(): void
    {
        $user = $this->createMember();

        $response = $this->actingAs($user)
            ->deleteJson("/api/tasks/99999");

        $response->assertStatus(404);
    }

    public function test_deleting_task_also_removes_its_favorites(): void
    {
        $admin   = $this->createAdmin();
        $member1 = $this->createMember();
        $member2 = $this->createMember();

        // Criar uma tarefa
        $task = $this->createTask($member1);

        // Favoritar a tarefa por diferentes usuários
        $this->actingAs($member1)->postJson("/api/tasks/{$task->id}/favorite");
        $this->actingAs($member2)->postJson("/api/tasks/{$task->id}/favorite");

        // Verificar que os favoritos existem
        $this->assertDatabaseCount('task_favorites', 1);

        // Admin exclui a tarefa
        $this->actingAs($admin)
            ->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(204);

        // Verificar que a tarefa foi excluída
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);

        // Verificar que os favoritos foram excluídos
        $this->assertDatabaseCount('task_favorites', 0);
    }

    public function test_unauthenticated_user_cannot_delete_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(401);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }
}
