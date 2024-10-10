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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->string('title')->unique();
            $table->text('description');
            $table->dateTime('created_at');
            $table->dateTime('submission_at')->nullable();
            $table->dateTime('assigment_at')->nullable();
            $table->dateTime('review_at')->nullable();
            $table->dateTime('decision_at')->nullable();
            $table->dateTime('final_submission_at')->nullable();
            $table->dateTime('final_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
