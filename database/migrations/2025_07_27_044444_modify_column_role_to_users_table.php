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
        // Add school_creator role to existing users table role enum (if using enum)
        // If you're using varchar for role, no schema change is needed
        
        // Update any existing role constraints if necessary
        // This is just a reference - adjust based on your current schema
        
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM(
            'super_admin',
            'school_admin', 
            'school_creator',
            'director',
            'manager',
            'head_master',
            'secretary',
            'academic_master',
            'teacher',
            'staff',
            'school_doctor',
            'school_librarian',
            'parent',
            'student'
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove school_creator role from enum (if using enum)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM(
            'super_admin',
            'school_admin',
            'director',
            'manager',
            'head_master',
            'secretary',
            'academic_master',
            'teacher',
            'staff',
            'school_doctor',
            'school_librarian',
            'parent',
            'student'
        )");
    }
};