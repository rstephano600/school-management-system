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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('exam_type_id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->decimal('total_marks', 6, 2);
            $table->decimal('passing_marks', 6, 2);
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grade_levels')->onDelete('set null');
            $table->foreign('subject_id')->references('id')->on('subject')->onDelete('set null');
            $table->foreign('created_by')->references('user_id')->on('teachers')->onDelete('cascade');
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
