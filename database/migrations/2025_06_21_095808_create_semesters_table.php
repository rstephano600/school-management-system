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
Schema::create('semesters', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->string('name'); // e.g., "Semester 1", "Muhula wa Kwanza"
    $table->date('start_date');
    $table->date('end_date');
    $table->boolean('is_current')->default(false);
    $table->timestamps();
    $table->foreign('school_id')
        ->references('id')
        ->on('schools')
        ->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
});

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
