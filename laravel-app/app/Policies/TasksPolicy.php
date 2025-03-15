<?php

namespace App\Policies;


use App\Models\Task;
use Illuminate\Auth\Access\Response;

class TasksPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Task $tasks): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the  can permanently delete the model.
     */
    public function forceDelete(Task $task): bool
    {
        return true;
    }
}
