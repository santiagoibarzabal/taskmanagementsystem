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
        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->uuid('task_id');
            $table->uuid('user_id')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user');
    }
};
