<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskIndexTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_admin_can_see_all_tasks(): void
    {
        // Criar os usuários e tarefas
        $admin   = $this->createAdmin();
        $member1 = $this->createMember();
        $member2 = $this->createMember();

        // Criar tarefas para cada usuário
        $adminTask   = $this->createTask($admin);
        $member1Task = $this->createTask($member1);
        $member2Task = $this->createTask($member2);

        // Admin deve ver todas as tarefas
        $response = $this->actingAs($admin)
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment(['id' => $adminTask->id])
            ->assertJsonFragment(['id' => $member1Task->id])
            ->assertJsonFragment(['id' => $member2Task->id]);
    }

    public function test_manager_can_see_all_tasks(): void
    {
        // Criar os usuários e tarefas
        $manager = $this->createManager();
        $member1 = $this->createMember();
        $member2 = $this->createMember();

        // Criar tarefas para cada usuário
        $managerTask = $this->createTask($manager);
        $member1Task = $this->createTask($member1);
        $member2Task = $this->createTask($member2);

        // Manager deve ver todas as tarefas
        $response = $this->actingAs($manager)
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment(['id' => $managerTask->id])
            ->assertJsonFragment(['id' => $member1Task->id])
            ->assertJsonFragment(['id' => $member2Task->id]);
    }

    public function test_regular_member_can_see_only_own_tasks(): void
    {
        // Criar os usuários e tarefas
        $member1 = $this->createMember();
        $member2 = $this->createMember();

        // Criar tarefas para cada usuário
        $member1Task = $this->createTask($member1);
        $member2Task = $this->createTask($member2);

        // Membro 1 deve ver apenas suas próprias tarefas
        $response = $this->actingAs($member1)
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['id' => $member1Task->id]);
    }

    public function test_tasks_can_be_filtered_by_status(): void
    {
        $user = $this->createMember();

        // Criar tarefas com diferentes status
        $pendingTask    = $this->createTask($user, ['status' => 'pending']);
        $inProgressTask = $this->createTask($user, ['status' => 'in_progress']);
        $completedTask  = $this->createTask($user, ['status' => 'completed']);

        // Filtrar por status pendente
        $response = $this->actingAs($user)
            ->getJson('/api/tasks?status=pending');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $pendingTask->id]);

        // Filtrar por status em progresso
        $response = $this->actingAs($user)
            ->getJson('/api/tasks?status=in_progress');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $inProgressTask->id]);

        // Filtrar por status completo
        $response = $this->actingAs($user)
            ->getJson('/api/tasks?status=completed');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $completedTask->id]);
    }

    public function test_unauthenticated_user_cannot_see_tasks(): void
    {
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(401);
    }
}
