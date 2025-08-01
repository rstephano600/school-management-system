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
Schema::create('subject_teacher', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('subject_id');
    $table->unsignedBigInteger('teacher_id');
    $table->timestamps();

    $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
    $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
    $table->unique(['subject_id', 'teacher_id']); // prevent duplicates
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};
