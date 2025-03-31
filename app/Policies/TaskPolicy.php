<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // futuramente criar times e verificar se o usuário é manager do time
        // para ele visualizar as tasks do time

        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // futuramente criar times e verificar se o usuário é manager do time
        // para ele editar a task do time

        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // futuramente criar times e verificar se o usuário é manager do time
        // para ele deletar a task do time

        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // futuramente criar times e verificar se o usuário é manager do time
        // para ele restaurar as tasks do time

        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can see all tasks in the system.
     */
    public function viewAll(User $user): bool
    {
        // Somente administradores e gerentes podem ver todas as tarefas no sistema
        return $user->isAdmin() || $user->isManager();
    }

    /**
     * Determine whether the user can assign tasks to other users.
     */
    public function assign(User $user): bool
    {
        // Somente administradores e gerentes podem atribuir tarefas a outras pessoas
        // futuramente criar times e verificar se o usuário é manager do time
        // para ele atribuir tarefas a outras pessoas do time
        return $user->isAdmin() || $user->isManager();
    }
}
