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
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('username', 150);
            $table->string('address', 255)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fullname', 256);
            $table->string('phone', 256);
            $table->tinyInteger('role', 10);
            $table->tinyInteger('status')->default(1);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
