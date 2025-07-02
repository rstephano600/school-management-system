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
        Schema::create('school_general_schedules', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->enum('day_of_week', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']);
    $table->string('activity'); // e.g. Lunch, Prayer, Assembly
    $table->time('start_time');
    $table->time('end_time');
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();

    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

    // ✅ Manual short name for unique index
    $table->unique(['school_id', 'day_of_week', 'start_time', 'activity'], 'gen_schedule_unique');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_general_schedules');
    }
};
