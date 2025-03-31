<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['admin', 'manager', 'member'])->default('member');
            $table->string('description');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });

        // Insere perfis
        DB::table('profiles')->insert([
            [
                'type'        => 'admin',
                'description' => 'Administrador',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'type'        => 'manager',
                'description' => 'Gerente de equipe',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'type'        => 'member',
                'description' => 'Membro da equipe',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
