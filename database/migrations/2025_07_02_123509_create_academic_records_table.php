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
Schema::create('academic_records', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('student_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->unsignedBigInteger('semester_id')->nullable();
    $table->unsignedBigInteger('class_id');
    $table->unsignedBigInteger('subject_id');

    $table->decimal('average_exam_score', 6, 2)->nullable();
    $table->decimal('average_assignment_score', 6, 2)->nullable();
    $table->decimal('final_score', 6, 2)->nullable();
    $table->string('final_grade', 5)->nullable();
    $table->text('remarks')->nullable();

    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
    $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
    $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
    $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');

    $table->unique(['student_id', 'academic_year_id', 'semester_id', 'subject_id'], 'unique_academic_record');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
