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
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->unsignedBigInteger('admitted_by');
            $table->unsignedBigInteger('school_id');
            $table->string('admission_number', 50)->unique();
            $table->date('admission_date');
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('roll_number', 20)->nullable();
            $table->date('date_of_birth');
            $table->char('gender', 1);
            $table->string('blood_group', 5)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->boolean('is_transport')->default(false);
            $table->boolean('is_hostel')->default(false);
            $table->enum('status', ['active', 'graduated', 'transferred'])->default('active');
            $table->json('previous_school_info')->nullable();
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admitted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grade_levels')->onDelete('set null');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
