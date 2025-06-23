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
        Schema::create('room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('number', 20);
            $table->string('name', 100)->nullable();
            $table->string('building', 100);
            $table->string('floor', 10);
            $table->integer('capacity');
            $table->enum('room_type', ['classroom', 'lab', 'office', 'library', 'other']);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('room');
    }
};
