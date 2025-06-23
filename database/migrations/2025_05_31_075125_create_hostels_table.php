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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('name');
            $table->enum('type', ['boys', 'girls', 'co-ed']);
            $table->text('address');
            $table->string('contact_number', 20);
            $table->unsignedBigInteger('warden_id')->nullable();
            $table->unsignedInteger('capacity');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('warden_id')->references('user_id')->on('staff')->nullOnDelete();
    
            $table->index(['school_id', 'type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostels');
    }
};
