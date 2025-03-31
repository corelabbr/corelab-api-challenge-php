<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'profile_id'        => function () {
                // pega os IDs de todos os perfis
                $profileIds = Profile::pluck('id')->toArray();

                // se não tiver nenhum perfil, cria um perfil de membro padrão
                if (empty($profileIds)) {
                    return Profile::create([
                        'type'        => 'member',
                        'description' => 'Membro',
                    ])->id;
                }

                return $profileIds[array_rand($profileIds)];
            },
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
    * Indicate that the user is an admin.
    */
    public function admin(): static
    {
        return $this->state(function () {
            $adminProfile = Profile::where('type', 'admin')->first();

            if (! $adminProfile) {
                $adminProfile = Profile::create([
                    'type'        => 'admin',
                    'description' => 'Administrador',
                ]);
            }

            return [
                'profile_id' => $adminProfile->id,
            ];
        });
    }

    /**
     * Indicate that the user is a manager.
     */
    public function manager(): static
    {
        return $this->state(function () {
            $managerProfile = Profile::where('type', 'manager')->first();

            if (! $managerProfile) {
                $managerProfile = Profile::create([
                    'type'        => 'manager',
                    'description' => 'Gerente de equipe',
                ]);
            }

            return [
                'profile_id' => $managerProfile->id,
            ];
        });
    }

    /**
     * Indicate that the user is a regular member.
     */
    public function member(): static
    {
        return $this->state(function () {
            $memberProfile = Profile::where('type', 'member')->first();

            if (! $memberProfile) {
                $memberProfile = Profile::create([
                    'type'        => 'member',
                    'description' => 'Membro de equipe',
                ]);
            }

            return [
                'profile_id' => $memberProfile->id,
            ];
        });
    }
}
