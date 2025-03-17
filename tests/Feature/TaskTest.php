<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_uma_nova_tarefa()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Nova Tarefa',
            'color' => '#ff0000',
            'is_favorite' => false
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Nova Tarefa']);
    }

    public function test_lista_as_tarefas()
    {
        Task::factory()->create(['title' => 'Tarefa 1']);
        Task::factory()->create(['title' => 'Tarefa 2']);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_atualiza_uma_tarefa()
    {
        $task = Task::factory()->create(['title' => 'Tarefa Antiga']);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Tarefa Atualizada'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['title' => 'Tarefa Atualizada']);
    }

    public function test_exclui_uma_tarefa()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
