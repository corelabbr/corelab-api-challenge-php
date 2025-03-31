<?php

declare(strict_types = 1);

namespace Tests;

use App\Enums\ProfileEnum;
use App\Models\Profile;
use App\Models\User;

trait AuthTestTrait
{
    /**
     * Cria os perfis necessários para testes
     */
    protected function createProfiles(): array
    {
        $admin = Profile::firstOrCreate(
            ['type' => ProfileEnum::ADMIN->value],
            ['description' => 'Administrador']
        );

        $manager = Profile::firstOrCreate(
            ['type' => ProfileEnum::MANAGER->value],
            ['description' => 'Gerente de equipe']
        );

        $member = Profile::firstOrCreate(
            ['type' => ProfileEnum::MEMBER->value],
            ['description' => 'Membro de equipe']
        );

        return compact('admin', 'manager', 'member');
    }

    /**
     * Cria um usuário com um perfil específico
     */
    protected function createUser(string $profileType = 'member'): User
    {
        $profiles = $this->createProfiles();

        $profileId = match ($profileType) {
            'admin'   => $profiles['admin']->id,
            'manager' => $profiles['manager']->id,
            default   => $profiles['member']->id,
        };

        return User::factory()->create(['profile_id' => $profileId]);
    }

    /**
     * Cria um administrador
     */
    protected function createAdmin(): User
    {
        return $this->createUser('admin');
    }

    /**
     * Cria um gerente
     */
    protected function createManager(): User
    {
        return $this->createUser('manager');
    }

    /**
     * Cria um membro
     */
    protected function createMember(): User
    {
        return $this->createUser('member');
    }
}
