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
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('isbn', 20)->nullable();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('edition', 50)->nullable();
            $table->unsignedSmallInteger('year_published')->nullable();
            $table->string('category', 100)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('available_quantity');
            $table->string('rack_number', 50)->nullable();
            $table->enum('status', ['available', 'lost', 'damaged'])->default('available');
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_books');
    }
};
