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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name', 10);
            $table->string('code', 10);
            $table->unsignedBigInteger('grade_id');
            $table->integer('capacity');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('class_teacher_id')->nullable();
            $table->unsignedBigInteger('academic_year_id');
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grade_levels')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('room')->onDelete('set null');
            $table->foreign('class_teacher_id')->references('user_id')->on('teachers')->onDelete('set null');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
