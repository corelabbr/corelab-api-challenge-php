<?php

namespace App\Services\V1;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TaskService 
{
    public function index(?bool $favorite = null, ?string $color = null,  ?int $userId = null): Collection
    {
      $query = Task::query();

      if (!is_null($favorite)) {
          $query->where('favorite', $favorite);
      }
  
      if (!is_null($color)) {
          $query->where('color', $color);
      }
  
      return $query->orderBy('created_at', 'desc')->where('user_id', $userId)->get();
    }

    public function store(array $taskData, int $user): Task
    {   
        $taskData["user_id"] = $user;
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
