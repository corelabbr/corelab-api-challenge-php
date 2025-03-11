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
        Schema::create('notes', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('title', 70);
            $table->text('content');
            $table->boolean('favorite')->default(false);
            $table->enum('color',['#A99A7C','#9DD6FF','#FFA285','#FFE8AC','#979797','#F99494','#DAFF8B','#B9FFDD','#CDCDCD','#FFCAB9','#ECA1FF','#BAE2FF','#FFFF'])->default('#FFFF');
            $table->softDeletes();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
