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
        Schema::create('blogdetail', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('name', 255);
            $table->string('motangan', 255)->nullable();
            $table->string('cont', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->string('motasanpham', 255)->nullable();
            $table->foreignId('id_blog')->constrained('blog');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogdetail');
    }
};
