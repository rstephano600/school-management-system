<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToPaymentCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::table('payment_categories', function (Blueprint $table) {
            $table->softDeletes(); // adds `deleted_at` column
        });
    }

    public function down(): void
    {
        Schema::table('payment_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
