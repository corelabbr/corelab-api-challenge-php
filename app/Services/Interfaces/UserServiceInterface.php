<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Create a new user.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function createUser(array $data): User;

    /**
     * Get a user by ID.
     *
     * @param  int  $id
     * @return \App\Models\User|null
     */
    public function getUserById(int $id): ?User;

    /**
     * Update a user by ID.
     *
     * @param  int  $id
     * @param  array  $data
     * @return \App\Models\User
     */
    public function updateUser(int $id, array $data): User;

    /**
     * Delete a user by ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteUser(int $id): bool;
}
