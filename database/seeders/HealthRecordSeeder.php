<?php

use App\Models;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthRecordSeeder extends Seeder
{
public function run(): void
{
    $records = [
    [
        'school_id' => 1,
        'student_id' => 10,
        'record_date' => '2025-03-05',
        'height' => 145.5,
        'weight' => 40.2,
        'blood_group' => 'O+',
        'vision_left' => '6/6',
        'vision_right' => '6/9',
        'allergies' => json_encode(['Peanuts']),
        'medical_conditions' => json_encode(['Asthma']),
        'immunizations' => json_encode(['Polio', 'MMR']),
        'last_checkup_date' => '2025-01-20',
        'notes' => 'Recommended regular inhaler usage.',
        'created_by' => 5
    ],
    [
        'school_id' => 1,
        'student_id' => 11,
        'record_date' => '2025-02-12',
        'height' => 152.3,
        'weight' => 48.7,
        'blood_group' => 'A-',
        'vision_left' => '6/6',
        'vision_right' => '6/6',
        'allergies' => json_encode([]),
        'medical_conditions' => json_encode([]),
        'immunizations' => json_encode(['Tetanus']),
        'last_checkup_date' => '2024-11-30',
        'notes' => 'Fit and healthy.',
        'created_by' => 5
    ],
    [
        'school_id' => 1,
        'student_id' => 10,
        'record_date' => '2025-03-05',
        'height' => 160.0,
        'weight' => 55.5,
        'blood_group' => 'B+',
        'vision_left' => '6/12',
        'vision_right' => '6/6',
        'allergies' => json_encode(['Dust', 'Pollen']),
        'medical_conditions' => json_encode(['Eczema']),
        'immunizations' => json_encode(['HPV', 'BCG']),
        'last_checkup_date' => '2025-02-14',
        'notes' => 'Needs follow-up with dermatologist.',
        'created_by' => 7
    ]
];
 // use the sample above

    foreach ($records as $record) {
        $record['allergies'] = json_decode($record['allergies']);
        $record['medical_conditions'] = json_decode($record['medical_conditions']);
        $record['immunizations'] = json_decode($record['immunizations']);
        HealthRecord::create($record);
    }
}
}