<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Task;
use App\Models\TaskColor;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    /**
     * TaskService constructor
     *
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Obtém todas as tarefas para o usuário autenticado
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllTasks(int $perPage = 15): LengthAwarePaginator
    {
        $user = Auth::user();

        // Administrador e gerente podem ver todas as tarefas
        if (Gate::allows('viewAll', Task::class)) {
            return $this->taskRepository->getAll($perPage);
        }

        // Os membros só podem ver suas tarefas
        return $this->taskRepository->getAllForUser($user->id, $perPage);
    }

    /**
     * Obtém uma tarefa por id
     *
     * @param int $id
     * @return Task
     * @throws AuthorizationException
     */
    public function getTask(int $id): Task
    {
        $task = $this->taskRepository->findById($id);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        if (Gate::denies('view', $task)) {
            throw new AuthorizationException('Você não está autorizado a ver esta tarefa');
        }

        return $task;
    }

    /**
     * Cria uma nova tarefa
     *
     * @param array $data
     * @return Task
     */
    public function createTask(array $data): Task
    {
        $user = Auth::user();

        if (! isset($data['user_id']) && ! Gate::allows('assign', Task::class)) {
            $data['user_id'] = $user->id;
        }
        $data['user_id'] = $data['user_id'] ?? $user->id;
        $data['status']  = $data['status'] ?? 'pending';

        return $this->taskRepository->create($data);
    }

    /**
     * Atualiza uma tarefa existente
     *
     * @param int $id
     * @param array $data
     * @return Task
     * @throws AuthorizationException
     */
    public function updateTask(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        if (Gate::denies('update', $task)) {
            throw new AuthorizationException('Você não está autorizado a atualizar esta tarefa');
        }

        if (isset($data['user_id']) && Gate::denies('assign', Task::class)) {
            unset($data['user_id']);
        }

        $updatedTask = $this->taskRepository->update($id, $data);

        if (! $updatedTask) {
            abort(500, 'Falha ao atualizar a tarefa');
        }

        return $updatedTask;
    }

    /**
     * Deleta uma tarefa
     *
     * @param int $id
     * @return bool
     * @throws AuthorizationException
     */
    public function deleteTask(int $id): bool
    {
        $task = $this->taskRepository->findById($id);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        if (Gate::denies('delete', $task)) {
            throw new AuthorizationException('Você não está autorizado a excluir esta tarefa');
        }

        return $this->taskRepository->delete($id);
    }

    /**
     * Obtém tarefas por status
     *
     * @param string $status
     * @return Collection
     */
    public function getTasksByStatus(string $status): Collection
    {
        $user = Auth::user();

        // Administrador e gerente podem ver todas as tarefas com o status
        if (Gate::allows('viewAll', Task::class)) {
            return $this->taskRepository->findByStatus($status);
        }

        // Os membros só podem ver suas tarefas com o status
        return $this->taskRepository->findByUserAndStatus($user->id, $status);
    }

    /**
     * Assign a task to a user
     *
     * @param int $taskId
     * @param int $userId
     * @return Task
     * @throws AuthorizationException
     */
    public function assignTask(int $taskId, int $userId): Task
    {
        // Somente administradores e gerentes podem atribuir tarefas
        if (Gate::denies('assign', Task::class)) {
            throw new AuthorizationException('Você não está autorizado a atribuir tarefas');
        }

        $task = $this->taskRepository->findById($taskId);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        $user = User::find($userId);

        if (! $user) {
            abort(404, 'Usuário não encontrado');
        }

        return $this->taskRepository->update($taskId, ['user_id' => $userId]);
    }

    /**
     * Lista todas as cores de tarefas disponíveis
     *
     * @return Collection
     */
    public function getTaskColors(): Collection
    {
        return TaskColor::active()->get();
    }

    /**
     * atualiza a cor de uma tarefa
     *
     * @param int $taskId
     * @param int $colorId
     * @return Task
     * @throws AuthorizationException
     */
    public function updateTaskColor(int $taskId, int $colorId): Task
    {
        $task = $this->taskRepository->findById($taskId);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        if (Gate::denies('update', $task)) {
            throw new AuthorizationException('Você não está autorizado a atualizar esta tarefa');
        }

        // checa se a cor existe
        $color = TaskColor::find($colorId);

        if (! $color) {
            abort(404, 'Cor não encontrada');
        }

        return $this->taskRepository->update($taskId, ['color_id' => $colorId]);
    }

    /**
     * Busca as tarefas favoritas do usuário
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFavoriteTasks(int $perPage = 15): LengthAwarePaginator
    {
        $user = Auth::user();

        return $this->taskRepository->getFavoritesForUser($user->id, $perPage);
    }

    /**
     * Alterna o status de favorito de uma tarefa do usuário
     *
     * @param int $taskId
     * @return bool The new favorite status
     * @throws AuthorizationException
     */
    public function toggleFavorite(int $taskId): bool
    {
        $task = $this->taskRepository->findById($taskId);

        if (! $task) {
            abort(404, 'Tarefa não encontrada');
        }

        if (Gate::denies('view', $task)) {
            throw new AuthorizationException('Você não está autorizado a acessar esta tarefa');
        }

        $user = Auth::user();

        return $this->taskRepository->toggleFavorite($taskId, $user->id);
    }
}
