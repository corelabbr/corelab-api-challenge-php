<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class TaskRepository implements TaskRepositoryInterface
{
    protected Task $task;

    /**
     * TaskRepository constructor
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Obtém todas as tarefas com paginação
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Cache::remember("tasks.all.page." . request('page', 1), 60, function () use ($perPage) {
            return $this->task
                ->with(['user', 'color', 'favoritedBy'])
                ->withCount('favorites')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }

    /**
     * Obtém todas as tarefas de um usuário com paginação
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Cache::remember("user.{$userId}.tasks.page." . request('page', 1), 60, function () use ($userId, $perPage) {
            return $this->task
                ->where('user_id', $userId)
                ->with(['color', 'favoritedBy'])
                ->withCount('favorites')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }

    /**
     * Encontra uma tarefa pelo ID
     *
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return Cache::remember("task.{$id}", 60, function () use ($id) {
            return $this->task
                ->with(['user', 'color', 'favoritedBy'])
                ->withCount('favorites')
                ->find($id);
        });
    }

    /**
     * Cria uma nova tarefa
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        $task = $this->task->create($data);

        // Limpa o cache das tarefas do usuário
        $this->clearUserTasksCache($data['user_id']);

        // Limpa todas as tarefas armazenada no cache
        $this->clearAllTasksCache();

        return $task;
    }

    /**
     * Atualiza uma tarefa existente
     *
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    public function update(int $id, array $data): ?Task
    {
        $task = $this->findById($id);

        if (! $task) {
            return null;
        }

        $task->update($data);

        // Limpa caches
        Cache::forget("task.{$id}");
        $this->clearUserTasksCache($task->user_id);

        // Se o user_id alterar, limpa o cache para o antigo e o novo usuário
        if (isset($data['user_id']) && $task->user_id != $data['user_id']) {
            $this->clearUserTasksCache($data['user_id']);
        }

        // Limpa todas as tarefas armazenada no cache
        $this->clearAllTasksCache();

        return $task->fresh();
    }

    /**
     * Deleta uma tarefa existente
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $task = $this->findById($id);

        if (! $task) {
            return false;
        }

        $userId = $task->user_id;
        $result = $task->delete();

        // Limpa caches
        Cache::forget("task.{$id}");
        $this->clearUserTasksCache($userId);

        // Limpa todas as tarefas armazenada no cache
        $this->clearAllTasksCache();

        return $result;
    }

    /**
     * Encontra tarefas por status para um usuário
     *
     * @param int $userId
     * @param string $status
     * @return Collection
     */
    public function findByUserAndStatus(int $userId, string $status): Collection
    {
        return Cache::remember("user.{$userId}.tasks.status.{$status}", 60, function () use ($userId, $status) {
            return $this->task
                ->where('user_id', $userId)
                ->where('status', $status)
                ->with(['color', 'favorites'])
                ->withCount('favorites')
                ->orderBy('due_date', 'asc')
                ->get();
        });
    }

    /**
     * Encontra tarefas por status
     *
     * @param string $status
     * @return Collection
     */
    public function findByStatus(string $status): Collection
    {
        return Cache::remember("tasks.status.{$status}", 60, function () use ($status) {
            return $this->task
                ->where('status', $status)
                ->with(['user', 'color', 'favorites'])
                ->withCount('favorites')
                ->orderBy('due_date', 'asc')
                ->get();
        });
    }

    /**
     * Lista todas as tarefas favoritas de um usuário
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFavoritesForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Cache::remember("user.{$userId}.favorites.page." . request('page', 1), 60, function () use ($userId, $perPage) {
            return $this->task
                ->whereHas('favoritedBy', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->with(['user', 'color', 'favorites'])
                ->withCount('favorites')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }

    /**
     * Alterna o status favorito de uma tarefa
     *
     * @param int $taskId
     * @param int $userId
     * @return bool The new favorite status
     */
    public function toggleFavorite(int $taskId, int $userId): bool
    {
        $task = $this->findById($taskId);

        if (! $task) {
            return false;
        }

        $isFavorited = $task->favoritedBy()->where('user_id', $userId)->exists();

        if ($isFavorited) {
            $task->favoritedBy()->detach($userId);
            $newStatus = false;
        } else {
            $task->favoritedBy()->attach($userId);
            $newStatus = true;
        }

        // Clear caches
        Cache::forget("task.{$taskId}");
        $this->clearUserTasksCache($task->user_id);
        Cache::forget("user.{$userId}.favorites.page." . request('page', 1));

        return $newStatus;
    }

    /**
     * Limpa caches da tarefa de um usuário
     *
     * @param int $userId
     * @return void
     */
    private function clearUserTasksCache(int $userId): void
    {
        Cache::forget("user.{$userId}.tasks.page." . request('page', 1));

        // Limpa status caches
        $statuses = ['pending', 'in_progress', 'completed'];

        foreach ($statuses as $status) {
            Cache::forget("user.{$userId}.tasks.status.{$status}");
        }
    }

    /**
     * Limpa todos os caches de tarefas
     *
     * @return void
     */
    private function clearAllTasksCache(): void
    {
        Cache::forget("tasks.all.page." . request('page', 1));

        // Limpa status caches para todas tarefas
        $statuses = ['pending', 'in_progress', 'completed'];

        foreach ($statuses as $status) {
            Cache::forget("tasks.status.{$status}");
        }
    }
}
