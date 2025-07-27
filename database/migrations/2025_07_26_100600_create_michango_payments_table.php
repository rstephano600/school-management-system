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

Schema::create('michango_payments', function (Blueprint $table) {
    $table->id();
    $table->string('payment_reference')->unique();
    $table->foreignId('student_michango_id')->constrained('student_michango')->onDelete('cascade');
    $table->decimal('amount', 12, 2);
    $table->date('payment_date');
    $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money', 'cheque', 'card', 'in_kind'])->default('cash');
    $table->string('payment_reference_number')->nullable();
    $table->text('payment_description')->nullable();
    $table->foreignId('received_by')->constrained('users');
    $table->foreignId('verified_by')->nullable()->constrained('users');
    $table->timestamp('verified_at')->nullable();
    $table->timestamps();
    
    $table->index(['payment_date', 'student_michango_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('michango_payments');
    }
};
