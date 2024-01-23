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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('keyword', 255)->nullable();
            $table->string('desc', 255)->nullable();
            $table->string('content', 255)->nullable();
            $table->integer('discount')->nullable();
            $table->string('price', 255)->nullable();
            $table->string('price_old', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('image_secondary', 256)->nullable();
            $table->string('images', 255)->nullable();
            $table->foreignId('id_cat')->constrained('category');
            $table->string('date_create', 255)->nullable();
            $table->string('date_edit', 255)->nullable();
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
