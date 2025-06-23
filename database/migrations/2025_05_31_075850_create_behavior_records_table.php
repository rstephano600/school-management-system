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
        Schema::create('behavior_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            $table->date('incident_date');
            $table->enum('incident_type', ['disruption', 'bullying', 'cheating', 'absenteeism', 'other']);
            $table->text('description');
            $table->text('action_taken');
            $table->enum('status', ['open', 'resolved'])->default('open');
            $table->unsignedBigInteger('reported_by');
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->date('resolved_date')->nullable();
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('resolved_by')->references('id')->on('users')->nullOnDelete();
    
            $table->index(['school_id', 'incident_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_records');
    }
};
