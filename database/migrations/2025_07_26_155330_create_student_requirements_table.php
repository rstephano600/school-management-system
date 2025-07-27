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
    Schema::create('student_requirements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('school_id')->constrained()->onDelete('cascade');
    $table->string('name'); // e.g., Fagio, Fyekeo, Rimu
    $table->text('description')->nullable();
    $table->boolean('allow_payment')->default(true); // if item can be replaced with money
    $table->decimal('expected_amount', 10, 2)->nullable(); // amount to be paid if allowed
    $table->foreignId('grade_level_id')->nullable()->constrained(); // specific to grade
    $table->timestamps();
    $table->foreignId('created_by')->nullable()->constrained('users');
    $table->foreignId('updated_by')->nullable()->constrained('users');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_requirements');
    }
};

