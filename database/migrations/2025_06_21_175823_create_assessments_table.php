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
    Schema::create('assessments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->unsignedBigInteger('academic_year_id');
        $table->unsignedBigInteger('grade_id');
        $table->unsignedBigInteger('class_id');
        $table->unsignedBigInteger('subject_id');
        $table->unsignedBigInteger('teacher_id');
        
        $table->enum('type', ['exam', 'test', 'assignment', 'exercise', 'labs']);
        $table->string('title');
        $table->text('description')->nullable();
        $table->date('issue_date');
        $table->date('due_date')->nullable();
        $table->boolean('is_published')->default(false); // visible to students?

        $table->timestamps();

        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
        $table->foreign('grade_id')->references('id')->on('grade_levels')->onDelete('cascade');
        $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
        $table->foreign('teacher_id')->references('user_id')->on('teachers')->onDelete('cascade');
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
