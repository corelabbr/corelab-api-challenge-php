<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_create_new_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson("api/v1/task",[
            "title" => "setima tarefa",
            "description" => "setima tarefa",
            "favorite" => true,
            "color" => "#757474"
        ]);

        $response->assertStatus(201);
    }

    public function test_it_can_list_all_tasks():void 
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::factory()->count(2)->create();
        $response = $this->getJson("api/v1/task");
        $response->assertJsonCount(2);
    }

    public function test_it_cat_update_a_task()
    {   
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'title' => 'Tarefa 1',
            'description' => 'Tarefa',
            'favorite' => true,
            'color' => '#FFFFFF'
        ]);

        $updateData = [
            'title' => 'Tarefa alterada',
            'description' => 'Tarefa alterada',
            'favorite' => true,
            'color' => '#FFFFFF',
        ];

        $response = $this->put("api/v1/task/{$task->id}", $updateData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Tarefa alterada',
            'description' => 'Tarefa alterada'
        ]);
    }

    public function test_it_can_delete_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();

        $response = $this->delete("api/v1/task/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_it_returns_404_if_task_not_found_for_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
            
        $response = $this->patch("api/v1/task/999", ['title' => 'Updated title']);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Tarefa não encontrada.']);
    }

    public function test_it_returns_404_if_task_not_found_for_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/task/999");

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Tarefa não encontrada.']);
    }
}
