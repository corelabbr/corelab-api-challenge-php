<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskFavoritesTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_user_can_favorite_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $response = $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/favorite");

        $response->assertStatus(200)
            ->assertJson([
                'is_favorited' => true,
                'message'      => 'Tarefa adicionada aos favoritos',
            ]);

        $this->assertDatabaseHas('task_favorites', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_user_can_unfavorite_task(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        // Favoritar primeiro
        $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/favorite");

        // Desfavoritar
        $response = $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/favorite");

        $response->assertStatus(200)
            ->assertJson([
                'is_favorited' => false,
                'message'      => 'Tarefa removida dos favoritos',
            ]);

        $this->assertDatabaseMissing('task_favorites', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_user_cannot_favorite_others_task(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $task    = $this->createTask($member2);

        // member1 tenta favoritar tarefa do member2
        $response = $this->actingAs($member1)
            ->postJson("/api/tasks/{$task->id}/favorite");

        // Mesmo que não possa visualizar, deve poder favoritar
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Você não está autorizado a acessar esta tarefa',
            ]);

        $this->assertDatabaseCount('task_favorites', 0);
    }

    public function test_returned_tasks_include_favorited_status(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        // Favoritar a tarefa
        $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/favorite");

        // Obter a tarefa
        $response = $this->actingAs($user)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'           => $task->id,
                    'is_favorited' => true,
                ],
            ]);
    }

    public function test_returns_404_for_nonexistent_task_favorite(): void
    {
        $user = $this->createMember();

        $response = $this->actingAs($user)
            ->postJson("/api/tasks/99999/favorite");

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_favorite_tasks(): void
    {
        $user = $this->createMember();
        $task = $this->createTask($user);

        $response = $this->postJson("/api/tasks/{$task->id}/favorite");

        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_get_favorites(): void
    {
        $response = $this->getJson("/api/tasks/favorites");

        $response->assertStatus(401);
    }
}
