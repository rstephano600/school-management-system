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
Schema::create('student_grade_levels', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('student_id'); // references students.user_id
    $table->unsignedBigInteger('grade_level_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->date('start_date');
    $table->date('end_date')->nullable(); // null if still active
    $table->boolean('is_current')->default(false);
    $table->timestamps();

    $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
    $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grade_levels');
    }
};
