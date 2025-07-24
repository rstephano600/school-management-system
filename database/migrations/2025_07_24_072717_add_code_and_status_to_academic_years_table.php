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
        Schema::table('academic_years', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name'); // Or make it unique if needed
            $table->enum('status', ['active', 'inactive'])->default('active')->after('is_current');
        });
    }

    public function down(): void
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn(['code', 'status']);
        });
    }
};
