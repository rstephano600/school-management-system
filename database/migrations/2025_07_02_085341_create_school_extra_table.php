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
       Schema::create('tests_timetable', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->unsignedBigInteger('class_id');
    $table->unsignedBigInteger('subject_id');
    $table->unsignedBigInteger('teacher_id');
    $table->date('test_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->string('title');
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years');
    $table->foreign('class_id')->references('id')->on('classes');
    $table->foreign('subject_id')->references('id')->on('subject');
    $table->foreign('teacher_id')->references('user_id')->on('teachers');
});
       Schema::create('exams_timetable', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->unsignedBigInteger('class_id');
    $table->unsignedBigInteger('subject_id');
    $table->unsignedBigInteger('teacher_id');
    $table->date('test_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->string('title');
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years');
    $table->foreign('class_id')->references('id')->on('classes');
    $table->foreign('subject_id')->references('id')->on('subject');
    $table->foreign('teacher_id')->references('user_id')->on('teachers');
});

Schema::create('holidays_timetable', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->string('name');
    $table->date('start_date');
    $table->date('end_date');
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years');
});

Schema::create('school_events', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('academic_year_id');
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('event_date');
    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();
    $table->string('location')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('academic_year_id')->references('id')->on('academic_years');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests_timetable');
        Schema::dropIfExists('exams_timetable');
        Schema::dropIfExists('holidays_timetable');
        Schema::dropIfExists('school_events');
    }
};
