<?php

use Illuminate\Database\Seeder;
use App\Models\HealthRecord;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HealthRecordSeeder extends Seeder
{
    public function run()
    {
        $studentsSchool1 = DB::table('students')->where('school_id', 1)->pluck('user_id')->take(10);
        $studentsSchool2 = DB::table('students')->where('school_id', 2)->pluck('user_id')->take(10);

        $records = [];

        foreach ($studentsSchool1 as $studentId) {
            $records[] = $this->generateHealthRecord(1, $studentId);
        }

        foreach ($studentsSchool2 as $studentId) {
            $records[] = $this->generateHealthRecord(2, $studentId);
        }

        HealthRecord::insert($records);
    }

    private function generateHealthRecord($schoolId, $studentId)
    {
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $allergies = ['Pollen', 'Dust', 'Peanuts', 'None'];
        $conditions = ['Asthma', 'Diabetes', 'Epilepsy', 'None'];
        $immunizations = ['Polio', 'BCG', 'MMR', 'Tetanus'];

        return [
            'school_id' => $schoolId,
            'student_id' => $studentId,
            'record_date' => Carbon::now()->subDays(rand(5, 300)),
            'height' => rand(140, 180), // cm
            'weight' => rand(40, 70), // kg
            'blood_group' => $bloodGroups[array_rand($bloodGroups)],
            'vision_left' => rand(6, 12) . '/6',
            'vision_right' => rand(6, 12) . '/6',
            'allergies' => json_encode([Arr::random($allergies)]),
            'medical_conditions' => json_encode([Arr::random($conditions)]),
            'immunizations' => json_encode(array_rand(array_flip($immunizations), 2)),
            'last_checkup_date' => Carbon::now()->subDays(rand(10, 150)),
            'notes' => fake()->sentence(),
            'created_by' => 1, // Assumes admin or doctor user_id = 1
        ];
    }
}
