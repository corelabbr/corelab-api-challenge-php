<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /** 
     * Valores a serem inseridos na tabela
    */
    private array $fields = [
        [
            'name' => 'Gustavo Sachetto',
            'email' => 'gustavo@gmail.com',
            'password' => 'admin',
            'telephone' => '11934455430',
            'birth_date' => '31-08-2006'
        ],
        [
            'name' => 'Gustavo Gualda',
            'email' => 'gualda@gmail.com',
            'password' => 'admin',
            'telephone' => '11938655430',
            'birth_date' => '30-11-2006'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->fields as $value) {
            DB::table('users')->insert($value);
        }
    }
}
