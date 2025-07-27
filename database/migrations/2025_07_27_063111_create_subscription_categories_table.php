<?php

// database/migrations/xxxx_xx_xx_create_subscription_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Basic, Pro, Enterprise
            $table->text('description')->nullable();
            $table->unsignedInteger('max_students'); // max number of students allowed
            $table->decimal('price', 10, 2); // subscription price
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_categories');
    }
}

