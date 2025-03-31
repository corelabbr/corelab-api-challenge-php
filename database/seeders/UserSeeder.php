<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name'     => 'Admininastro',
            'email'    => 'admin@email.com',
            'password' => 'password',
        ]);

        User::factory()->manager()->create([
            'name'     => 'Gerente',
            'email'    => 'manager@email.com',
            'password' => 'password',
        ]);

        User::factory()->member()->create([
            'name'     => 'Membro',
            'email'    => 'member@email.com',
            'password' => 'password',
        ]);

        User::factory()->count(5)->create();
    }
}
