<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notices', function (Blueprint $table) {
            // Change content from TEXT to STRING to hold file path
            $table->string('content')->nullable()->change(); // now holds file name/path
            $table->string('topic')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->text('content')->change();
            $table->dropColumn('topic');
        });
    }
};

