<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); ;  // Nome do usuário
            $table->string('email')->unique();  // Email único
            $table->timestamp('email_verified_at')->nullable();  // Data de verificação do email
            $table->string('password');  // Senha do usuário
            $table->rememberToken();  // Token para "lembrar login"
            $table->timestamps();  // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
