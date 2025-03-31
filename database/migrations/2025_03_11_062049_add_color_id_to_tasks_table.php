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
        Schema::table('tasks', function (Blueprint $table) {
            // Obtém o ID da cor azul (será a cor padrão)
            $blueColorId = DB::table('task_colors')->where('name', 'Azul')->value('id');

            $table->foreignId('color_id')
                ->after('status')
                ->nullable()
                ->default($blueColorId)
                ->constrained('task_colors')
                ->onDelete('set null');

            // verifica se existem tarefas existentes antes de atualizar
            // Atualiza todas as tarefas existentes para usar a cor azul
            if (DB::table('tasks')->exists() && $blueColorId) {
                DB::table('tasks')->update(['color_id' => $blueColorId]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropColumn('color_id');
        });
    }
};
