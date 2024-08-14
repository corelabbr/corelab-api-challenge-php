<?php

namespace App\Policies;

use App\Models\TodoItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodoItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TodoItem $todoItem): Response
    {
        return $todoItem->checkOwnership($user)
            ? Response::allow()
            : Response::deny('You do not own this todo item.');
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
    public function update(User $user, TodoItem $todoItem): bool
    {
        return $todoItem->checkOwnership($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TodoItem $todoItem): bool
    {
        return $todoItem->checkOwnership($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TodoItem $todoItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TodoItem $todoItem): bool
    {
        return false;
    }
}
