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
Schema::create('student_requirement_submissions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students', 'user_id')->onDelete('cascade');
    $table->foreignId('student_requirement_id')->constrained()->onDelete('cascade');

    $table->enum('fulfilled_by', ['item', 'payment', 'none'])->default('none');
    $table->decimal('amount_paid', 10, 2)->nullable(); // if fulfilled by payment
    $table->text('notes')->nullable(); // optional comments (e.g., “brought broken fyekeo”)
    
    $table->timestamps();
    $table->foreignId('created_by')->nullable()->constrained('users'); // person recording
    $table->foreignId('updated_by')->nullable()->constrained('users');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_requirement_submissions');
    }
};
