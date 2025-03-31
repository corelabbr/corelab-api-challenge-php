<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Task;

use Tests\AuthTestTrait;
use Tests\TaskTestTrait;
use Tests\TestCase;

class TaskColorsTest extends TestCase
{
    use TaskTestTrait;
    use AuthTestTrait;

    public function test_user_can_update_task_color(): void
    {
        $user   = $this->createMember();
        $colors = $this->createTaskColors();
        $task   = $this->createTask($user, ['color_id' => $colors['blue']->id]);

        $response = $this->actingAs($user)
            ->putJson("/api/tasks/{$task->id}/color/{$colors['red']->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $task->id,
                    'color' => [
                        'id'   => $colors['red']->id,
                        'name' => 'Vermelho',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'id'       => $task->id,
            'color_id' => $colors['red']->id,
        ]);
    }

    public function test_admin_can_update_any_task_color(): void
    {
        $admin  = $this->createAdmin();
        $member = $this->createMember();
        $colors = $this->createTaskColors();
        $task   = $this->createTask($member, ['color_id' => $colors['blue']->id]);

        $response = $this->actingAs($admin)
            ->putJson("/api/tasks/{$task->id}/color/{$colors['red']->id}");

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id'       => $task->id,
            'color_id' => $colors['red']->id,
        ]);
    }

    public function test_regular_member_cannot_update_others_task_color(): void
    {
        $member1 = $this->createMember();
        $member2 = $this->createMember();
        $colors  = $this->createTaskColors();
        $task    = $this->createTask($member2, ['color_id' => $colors['blue']->id]);

        $response = $this->actingAs($member1)
            ->putJson("/api/tasks/{$task->id}/color/{$colors['red']->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id'       => $task->id,
            'color_id' => $colors['blue']->id, // Cor não deve mudar
        ]);
    }

    public function test_returns_404_for_nonexistent_task_or_color(): void
    {
        $user   = $this->createMember();
        $colors = $this->createTaskColors();
        $task   = $this->createTask($user);

        // Testar cor inexistente
        $response = $this->actingAs($user)
            ->putJson("/api/tasks/{$task->id}/color/99999");

        $response->assertStatus(404);

        // Testar tarefa inexistente
        $response = $this->actingAs($user)
            ->putJson("/api/tasks/99999/color/{$colors['red']->id}");

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_access_colors(): void
    {
        $response = $this->getJson('/api/tasks/colors');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_update_task_color(): void
    {
        $user   = $this->createMember();
        $colors = $this->createTaskColors();
        $task   = $this->createTask($user);

        $response = $this->putJson("/api/tasks/{$task->id}/color/{$colors['red']->id}");

        $response->assertStatus(401);
    }
}
