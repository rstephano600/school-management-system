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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('due_date');
            $table->decimal('max_points', 6, 2);
            $table->enum('assignment_type', ['homework', 'quiz', 'test', 'other']);
            $table->string('file')->nullable(); // store file path
            $table->enum('status', ['draft', 'published', 'graded'])->default('draft');
            $table->unsignedBigInteger('created_by'); // teacher_id
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('created_by')->references('user_id')->on('teachers')->onDelete('cascade');
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
