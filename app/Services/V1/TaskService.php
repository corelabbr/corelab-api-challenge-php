<?php

namespace App\Services\V1;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService 
{
    public function index(?bool $favorite = null, ?string $color = null): Collection
    {
      $query = Task::query();

      if (!is_null($favorite)) {
          $query->where('favorite', $favorite);
      }
  
      if (!is_null($color)) {
          $query->where('color', $color);
      }
  
      return $query->get();
    }

    public function store(array $taskData): Task
    {
        return Task::create($taskData);
    }

    public function update(array $taskData, string $taskId): bool
    {
        $task = Task::findOrFail($taskId);
        return  $task->update($taskData);
    }

    public function destroy(string $taskId): bool
    {
        $task = Task::findOrFail($taskId);
        return  $task->delete($task);
    }
}
