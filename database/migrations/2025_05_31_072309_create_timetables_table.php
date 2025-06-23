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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedSmallInteger('day_of_week'); // 1=Monday ... 7=Sunday
            $table->unsignedSmallInteger('period_number');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->date('effective_from');
            $table->date('effective_to');
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('room')->onDelete('set null');
            $table->foreign('teacher_id')->references('user_id')->on('teachers')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
    
            $table->unique(['class_id', 'day_of_week', 'period_number', 'academic_year_id'], 'timetable_unique');
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
