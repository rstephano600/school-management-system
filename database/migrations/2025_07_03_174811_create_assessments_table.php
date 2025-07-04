<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('assessments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->string('title');
        $table->enum('type', ['exam', 'test', 'assignment', 'lab']);
        $table->unsignedBigInteger('grade_level_id');
        $table->unsignedBigInteger('subject_id');
        $table->unsignedBigInteger('academic_year_id');
        $table->unsignedBigInteger('semester_id')->nullable();
        $table->date('due_date')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();

        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('cascade');
        $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
        $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
