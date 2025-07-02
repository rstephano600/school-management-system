<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Nuru Stephano',
                'email' => 'rstephano600@school.com',
                'password' => Hash::make('am the school super admin 1'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'Stephano Robert ',
                'email' => 'cybernovasolutions@school.com',
                'password' => Hash::make('am the school super admin 2'),
                'role' => 'super_admin',
            ],
        ]);
    }
}

