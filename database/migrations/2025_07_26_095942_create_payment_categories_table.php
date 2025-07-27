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
// Payment Categories Table
        Schema::create('payment_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "School Fees", "Transport", "Meals", "Development Fee"
            $table->string('code')->unique(); // e.g., "SCH_FEES", "TRANSPORT", "MEALS", "DEV_FEE"
            $table->enum('type', ['mandatory', 'optional', 'conditional'])->default('mandatory');
            $table->enum('category', ['fees', 'bills', 'michango', 'other'])->default('fees');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('applicable_grades')->nullable(); // Array of grade IDs
            $table->enum('payment_frequency', ['once', 'monthly', 'termly', 'annually'])->default('termly');
            $table->boolean('required_at_registration')->default(false);
            $table->boolean('required_at_grade_entry')->default(false);
            $table->decimal('default_amount', 12, 2)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['school_id', 'is_active']);
            $table->index(['school_id', 'category']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_categories');
    }
};
