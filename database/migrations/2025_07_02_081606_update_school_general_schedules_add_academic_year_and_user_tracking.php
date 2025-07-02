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
        Schema::table('school_general_schedules', function (Blueprint $table) {
    $table->unsignedBigInteger('academic_year_id')->after('school_id');
    $table->unsignedBigInteger('created_by')->nullable()->after('status');
    $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');

    $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
