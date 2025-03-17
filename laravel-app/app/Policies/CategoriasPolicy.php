<?php

namespace App\Policies;


use App\Models\Categoria;
use Illuminate\Auth\Access\Response;

class CategoriasPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Categoria $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Categoria $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Categoria $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Categoria $categorias): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Categoria $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Categoria $categoria): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Categoria $categoria): bool
    {
        return true;
    }
}
