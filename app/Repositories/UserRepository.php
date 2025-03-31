<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * UserRepository constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Encontra um usuário pelo email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return Cache::remember("user.email.{$email}", 60, function () use ($email) {
            return $this->user->where('email', $email)->first();
        });
    }

    /**
     * Encontra um usuário pelo ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return Cache::remember("user.{$id}", 60, function () use ($id) {
            return $this->user->find($id);
        });
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        if (isset($data['password']) && ! Hash::isHashed($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Define o perfil padrão (member) se não for fornecido
        if (! isset($data['profile_id'])) {
            $memberProfileId = \App\Models\Profile::where('type', 'member')->value('id');

            if ($memberProfileId) {
                $data['profile_id'] = $memberProfileId;
            }
        }

        $user = $this->user->create($data);

        return $user->fresh();
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        $user = $this->findById($id);

        if (! $user) {
            return null;
        }

        if (isset($data['password']) && ! Hash::isHashed($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        // Limpa o cache do usuário e do email se for alterado
        Cache::forget("user.{$id}");

        if (isset($data['email'])) {
            Cache::forget("user.email.{$data['email']}");
        }
        Cache::forget("user.email.{$user->email}");

        return $user->fresh();
    }

    /**
     * Deleta todos os tokens de um usuário.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteTokens(int $userId): bool
    {
        $user = $this->findById($userId);

        if (! $user) {
            return false;
        }

        $user->tokens()->delete();

        return true;
    }

    /**
     * Cria um novo token para um usuário.
     *
     * @param User $user
     * @param string $name
     * @return string
     */
    public function createToken(User $user, ?string $name = null): string
    {
        $name = $name ?? config('app.authToken');

        return $user->createToken($name)->plainTextToken;
    }
}
