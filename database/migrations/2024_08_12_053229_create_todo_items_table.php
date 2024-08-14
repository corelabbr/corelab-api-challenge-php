<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignUuid('user_id')->constrained();
            $table->string('title');
            $table->boolean('completed')->default(false);
            $table->boolean('favorite')->default(false);
            $table->string('description')->nullable();
            $table->string('color')->default('#000000');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_items');
    }
};
