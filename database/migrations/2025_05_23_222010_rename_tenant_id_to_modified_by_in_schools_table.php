<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('schools', function (Blueprint $table) {
        $table->renameColumn('tenant_id', 'modified_by');
    });
}

public function down()
{
    Schema::table('schools', function (Blueprint $table) {
        $table->renameColumn('email', 'username');
    });
}
};
