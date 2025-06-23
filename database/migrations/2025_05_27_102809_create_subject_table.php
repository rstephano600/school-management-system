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
        Schema::create('subject', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('name', 100);
    $table->string('code', 20);
    $table->text('description')->nullable();
    $table->boolean('is_core')->default(false);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->index('school_id');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject');
    }
};
