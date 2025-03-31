<?php

declare(strict_types = 1);

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    /**
    * Obtém todas as tarefas com paginação
    *
    * @param int $perPage
    * @return LengthAwarePaginator
    */
    public function getAll(int $perPage = 15): LengthAwarePaginator;

    /**
     * Obtém todas as tarefas de um usuário com paginação
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Encontra uma tarefa pelo ID
     *
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task;

    /**
     * Cria uma nova tarefa
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task;

    /**
     * Atualiza uma tarefa existente
     *
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    public function update(int $id, array $data): ?Task;

    /**
     * Deleta uma tarefa existente
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Encontra tarefas por status para um usuário
     *
     * @param int $userId
     * @param string $status
     * @return Collection
     */
    public function findByUserAndStatus(int $userId, string $status): Collection;

    /**
     * Find all tasks with a specific status
     *
     * @param string $status
     * @return Collection
     */
    public function findByStatus(string $status): Collection;

    /**
     * Lista todas as tarefas favoritas de um usuário
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFavoritesForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Alterna o status favorito de uma tarefa
     *
     * @param int $taskId
     * @param int $userId
     * @return bool The new favorite status
     */
    public function toggleFavorite(int $taskId, int $userId): bool;
}
