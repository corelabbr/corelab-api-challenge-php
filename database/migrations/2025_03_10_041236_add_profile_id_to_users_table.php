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
        Schema::table('users', function (Blueprint $table) {
            // Obtém o ID do perfil padrão 'member'
            $memberProfileId = DB::table('profiles')->where('type', 'member')->value('id');

            $table->foreignId('profile_id')
                ->after('email')
                ->constrained('profiles')
                ->onDelete('restrict')
                ->default($memberProfileId ?? 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });
    }
};
