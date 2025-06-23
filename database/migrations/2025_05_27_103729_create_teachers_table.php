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
        Schema::create('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->unsignedBigInteger('school_id');
            $table->string('employee_id', 50)->unique();
            $table->date('joining_date');
            $table->string('qualification', 100);
            $table->string('specialization', 100);
            $table->string('experience', 50)->nullable();
            $table->string('department', 100)->nullable();
            $table->boolean('is_class_teacher')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
