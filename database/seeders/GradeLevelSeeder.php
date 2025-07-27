<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GradeLevel;

class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $gradeLevels = [
            [
                'school_id' => 1,
                'name' => 'Form One',
                'code' => 'F1',
                'level' => 'Ordinary Level',
                'description' => 'First year of secondary education in Tanzania',
            ],
            [
                'school_id' => 1,
                'name' => 'Form Two',
                'code' => 'F2',
                'level' => 'Ordinary Level',
                'description' => 'Second year of secondary education in Tanzania',
            ],
            [
                'school_id' => 1,
                'name' => 'Form Three',
                'code' => 'F3',
                'level' => 'Ordinary Level',
                'description' => 'Third year of secondary education in Tanzania',
            ],
            [
                'school_id' => 1,
                'name' => 'Form Four',
                'code' => 'F4',
                'level' => 'Ordinary Level',
                'description' => 'Fourth and final year of O-Level secondary education in Tanzania',
            ],
        ];

        foreach ($gradeLevels as $grade) {
            GradeLevel::create($grade);
        }
    }
}

