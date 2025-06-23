<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('route_name');
            $table->string('vehicle_number', 50);
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('attendant_id')->nullable();
            $table->string('start_point');
            $table->string('end_point');
            $table->json('stops')->nullable();
            $table->text('schedule');
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('driver_id')->references('user_id')->on('staff')->nullOnDelete();
            $table->foreign('attendant_id')->references('user_id')->on('staff')->nullOnDelete();
    
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};
