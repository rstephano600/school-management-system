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
        // Michango (Contributions) Categories Table
        Schema::create('michango_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "School Development", "Sports Equipment", "Library Books"
            $table->string('code')->unique();
            $table->text('description');
            $table->decimal('target_amount', 12, 2)->nullable();
            $table->decimal('collected_amount', 12, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('applicable_grades')->nullable();
            $table->enum('contribution_type', ['per_student', 'per_parent', 'voluntary'])->default('per_student');
            $table->decimal('suggested_amount', 12, 2)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['school_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('michango_categories');
    }
};
