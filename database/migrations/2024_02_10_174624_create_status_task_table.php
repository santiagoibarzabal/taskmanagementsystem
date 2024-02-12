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
        Schema::create('status_task', function (Blueprint $table) {
            $table->id();
            $table->uuid('status_id');
            $table->uuid('task_id');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->timestamp('created_at')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_task');
    }
};
