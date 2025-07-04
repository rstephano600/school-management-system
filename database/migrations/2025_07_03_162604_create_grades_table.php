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
    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->unsignedTinyInteger('min_score');
        $table->unsignedTinyInteger('max_score');
        $table->string('grade_letter', 2);
        $table->decimal('grade_point', 4, 2);
        $table->string('remarks', 100)->nullable();
        $table->string('level')->nullable();

        // 🔍 Tracking columns
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();

        $table->timestamps();

        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

        $table->index(['school_id', 'min_score', 'max_score']);
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
