<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name', 255)->unique();
            $table->string('code', 50)->unique();
            $table->text('address');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100)->default('YourCountry');
            $table->string('postal_code', 20);
            $table->string('phone', 20);
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->date('established_date');
            $table->boolean('status')->default(true);
            $table->timestamps();
    
            $table->index('tenant_id');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
