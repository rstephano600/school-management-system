<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'modified_by' => 1,
                'name' => 'Jangwani Secondary School',
                'code' => 'S0100',
                'address' => 'P.O. Box 1000',
                'city' => 'Dar es Salaam',
                'state' => 'Ilala',
                'country' => 'Tanzania',
                'postal_code' => '11101',
                'phone' => '0222123456',
                'email' => 'jangwani@moe.go.tz',
                'website' => 'https://jangwani.ac.tz',
                'logo' => null,
                'established_date' => '1980-01-01',
                'status' => '1',
            ],
            [
                'modified_by' => 1,
                'name' => 'Feza Boys High School',
                'code' => 'S0201',
                'address' => 'Kawe Beach',
                'city' => 'Dar es Salaam',
                'state' => 'Kinondoni',
                'country' => 'Tanzania',
                'postal_code' => '14122',
                'phone' => '0222700000',
                'email' => 'fezaboys@fezaschools.org',
                'website' => 'https://fezaschools.org',
                'logo' => null,
                'established_date' => '1995-01-01',
                'status' => '1',
            ],
            [
                'modified_by' => 1,
                'name' => 'Mzumbe Secondary School',
                'code' => 'S1001',
                'address' => 'P.O. Box 1',
                'city' => 'Mzumbe',
                'state' => 'Mvomero',
                'country' => 'Tanzania',
                'postal_code' => '67101',
                'phone' => '0232601234',
                'email' => 'mzumbe@moe.go.tz',
                'website' => null,
                'logo' => null,
                'established_date' => '1975-01-01',
                'status' => '0',
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
