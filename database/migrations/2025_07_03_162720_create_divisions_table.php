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
    Schema::create('divisions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->decimal('min_point', 5, 2);
        $table->decimal('max_point', 5, 2);
        $table->string('division', 20);
        $table->string('remarks', 100)->nullable();

        // 🔍 Tracking columns
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();

        $table->timestamps();

        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

        $table->index(['school_id', 'min_point', 'max_point']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
