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
        Schema::table('student_requirement_submissions', function (Blueprint $table) {
            $table->unsignedInteger('quantity_received')->nullable()->after('student_requirement_id');
            $table->unsignedInteger('quantity_remain')->nullable()->after('quantity_received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requirement_submissions', function (Blueprint $table) {
            
        });
    }
};
