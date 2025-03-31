<?php

declare(strict_types = 1);

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Encontra um usuário pelo email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Encontra um usuário pelo ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Cria um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Atualiza um usuário existente.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User;

    /**
     * Deleta todos os tokens de um usuário.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteTokens(int $userId): bool;

    /**
     * Cria um novo token para um usuário.
     *
     * @param User $user
     * @param string $name
     * @return string
     */
    public function createToken(User $user, ?string $name = null): string;
}
