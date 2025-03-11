<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'favorite' => true,
            'color' => '#FF5733'
        ];

        $response = $this->postJson('/api/tasks', $data);
        
        $response->assertStatus(201)
                 ->assertJsonFragment($data);
        
        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $updateData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'favorite' => false,
            'color' => '#0000FF'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('tasks', $updateData);
    }

    /** @test */
    public function it_can_update_task_color()
    {
        $task = Task::factory()->create();

        $updateColor = ['color' => '#ABCDEF'];

        $response = $this->patchJson("/api/tasks/{$task->id}/color", $updateColor);

        $response->assertStatus(200)
                 ->assertJsonFragment($updateColor);
    }

    /** @test */
    public function it_can_update_task_favorite_status()
    {
        $task = Task::factory()->create();

        $updateFavorite = ['favorite' => true];

        $response = $this->patchJson("/api/tasks/{$task->id}/favorite", $updateFavorite);

        $response->assertStatus(200)
                 ->assertJsonFragment($updateFavorite);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
