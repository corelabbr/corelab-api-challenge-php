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
        Schema::create('task_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('hex_code', 7)->unique();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });

        $colors = [
            ['name' => 'Vermelho', 'hex_code' => '#FF5252', 'description' => 'Vermelho vibrante para tarefas urgentes'],
            ['name' => 'Azul', 'hex_code' => '#4285F4', 'description' => 'Azul padrão para tarefas normais'],
            ['name' => 'Verde', 'hex_code' => '#0F9D58', 'description' => 'Verde para tarefas concluídas ou em andamento'],
            ['name' => 'Amarelo', 'hex_code' => '#FFCA28', 'description' => 'Amarelo para tarefas de atenção moderada'],
            ['name' => 'Roxo', 'hex_code' => '#9C27B0', 'description' => 'Roxo para tarefas criativas'],
            ['name' => 'Laranja', 'hex_code' => '#FF7043', 'description' => 'Laranja para tarefas de prioridade média'],
            ['name' => 'Ciano', 'hex_code' => '#00BCD4', 'description' => 'Ciano para tarefas relacionadas a comunicação'],
            ['name' => 'Rosa', 'hex_code' => '#E91E63', 'description' => 'Rosa para tarefas pessoais'],
            ['name' => 'Verde-água', 'hex_code' => '#26A69A', 'description' => 'Verde-água para tarefas de bem-estar'],
            ['name' => 'Cinza', 'hex_code' => '#757575', 'description' => 'Cinza para tarefas neutras ou de baixa prioridade'],
        ];

        DB::table('task_colors')->insert(array_map(function ($color) {
            return array_merge($color, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $colors));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_colors');
    }
};
