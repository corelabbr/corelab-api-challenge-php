<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskShowTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_admin_can_view_any_task(): void
    {
        // Criar admin e membro
        $admin  = $this->createAdmin();
        $member = $this->createMember();

        // Criar tarefa para o membro
        $task = $this->createTask($member);

        // Admin deve conseguir ver a tarefa do membro
        $response = $this->actingAs($admin)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $task->id,
                    'title' => $task->title,
                ],
            ]);
    }

    public function test_manager_can_view_any_task(): void
    {
        // Criar gerente e membro
        $manager = $this->createManager();
        $member  = $this->createMember();

        // Criar tarefa para o membro
        $task = $this->createTask($member);

        // Gerente deve conseguir ver a tarefa do membro
        $response = $this->actingAs($manager)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $task->id,
                    'title' => $task->title,
                ],
            ]);
    }

    public function test_regular_member_can_view_own_task(): void
    {
        // Criar membro
        $member = $this->createMember();

        // Criar tarefa para o membro
        $task = $this->createTask($member);

        // Membro deve conseguir ver sua própria tarefa
        $response = $this->actingAs($member)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $task->id,
                    'title' => $task->title,
                ],
            ]);
    }

    public function test_regular_member_cannot_view_other_users_task(): void
    {
        // Criar dois membros
        $member1 = $this->createMember();
        $member2 = $this->createMember();

        // Criar tarefa para o membro 2
        $task = $this->createTask($member2);

        // Membro 1 não deve conseguir ver a tarefa do membro 2
        $response = $this->actingAs($member1)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(403); // Forbidden
    }

    public function test_returns_404_for_nonexistent_task(): void
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user)
            ->getJson("/api/tasks/99999");

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_view_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(401);
    }
}
