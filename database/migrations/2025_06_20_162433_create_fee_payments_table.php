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
    Schema::create('fee_payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('fee_structure_id')->constrained()->onDelete('cascade');
    $table->decimal('amount_paid', 10, 2);
    $table->date('payment_date');
    $table->string('method');
    $table->string('reference')->nullable();
    $table->text('note')->nullable();

    // New field to track admin/secretary user
    $table->foreignId('received_by')->constrained('users')->onDelete('cascade');

    $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
