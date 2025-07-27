<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\SchoolGeneralSchedule;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class TimetableSeeder extends Seeder
{
    public function run()
    {
        // Create sample academic year
        $academicYear = AcademicYear::create([
            'school_id' => 1, // Adjust based on your school ID
            'name' => '2024/2025',
            'code' => 'AY2024-25',
            'start_date' => '2024-09-01',
            'end_date' => '2025-07-31',
            'status' => '1',
            'description' => 'Academic Year 2024/2025'
        ]);

        // Create sample subjects similar to the PDF
        $subjects = [
            ['name' => 'Blockchain Technology', 'code' => 'CG 322', 'is_core' => true],
            ['name' => 'Business Continuity and Disaster Recovery', 'code' => 'IA 421', 'is_core' => true],
            ['name' => 'Wireless Security', 'code' => 'IA 423', 'is_core' => true],
            ['name' => 'Ethical Hacking', 'code' => 'IA 422', 'is_core' => true],
            ['name' => 'Information Systems Forensics Internal Auditing', 'code' => 'IA 429', 'is_core' => true],
            ['name' => 'Trust Management in E-Commerce', 'code' => 'IA 428', 'is_core' => true],
            ['name' => 'Semantic Web and Social Networks', 'code' => 'CS 427', 'is_core' => true],
        ];

        foreach ($subjects as $subjectData) {
            Subject::create([
                'school_id' => 1,
                'user_id' => 1,
                'name' => $subjectData['name'],
                'code' => $subjectData['code'],
                'description' => 'Computer Science subject',
                'is_core' => $subjectData['is_core']
            ]);
        }

        // Create sample grade levels
        $gradeLevel = GradeLevel::create([
            'school_id' => 1,
            'name' => 'Fourth Year',
            'code' => 'Y4',
            'level' => 4,
            'description' => 'Fourth Year Computer Science'
        ]);

        // Create sample section
        $section = Section::create([
            'school_id' => 1,
            'user_id' => 1,
            'name' => 'CSDFE4',
            'code' => 'CSDFE4',
            'grade_id' => $gradeLevel->id,
            'capacity' => 50,
            'academic_year_id' => $academicYear->id,
            'status' => 1
        ]);

        // Create sample rooms
        $rooms = [
            ['name' => 'ELE_LAB', 'number' => 'ELE_LAB', 'building' => 'Main', 'floor' => '1', 'capacity' => 30, 'room_type' => 'lab'],
            ['name' => 'LRA 021', 'number' => 'LRA 021', 'building' => 'Main', 'floor' => '2', 'capacity' => 40, 'room_type' => 'classroom'],
            ['name' => 'LRB 004D', 'number' => 'LRB 004D', 'building' => 'Block B', 'floor' => '4', 'capacity' => 60, 'room_type' => 'library'],
            ['name' => 'NET_LAB', 'number' => 'NET_LAB', 'building' => 'Main', 'floor' => '1', 'capacity' => 25, 'room_type' => 'lab'],
            ['name' => 'LRB 005B', 'number' => 'LRB 005B', 'building' => 'Block B', 'floor' => '5', 'capacity' => 50, 'room_type' => 'classroom'],
            ['name' => 'LRB 102', 'number' => 'LRB 102', 'building' => 'Block B', 'floor' => '1', 'capacity' => 45, 'room_type' => 'classroom'],
            ['name' => 'SE_LAB', 'number' => 'SE_LAB', 'building' => 'Main', 'floor' => '2', 'capacity' => 30, 'room_type' => 'lab'],
        ];

        foreach ($rooms as $roomData) {
            Room::create([
                'school_id' => 1,
                'user_id' => 1,
                'number' => $roomData['number'],
                'name' => $roomData['name'],
                'building' => $roomData['building'],
                'floor' => $roomData['floor'],
                'capacity' => $roomData['capacity'],
                'room_type' => $roomData['room_type'],
                'status' => '1'
            ]);
        }

        // Create sample teachers (assuming you have users)
       $teachers = [
            [
                'name' => 'Dr. Salehe Mrutu', 
                'email' => 'salehe.mrutu@udom.ac.tz',
                'employee_id' => 'EMP001',
                'qualification' => 'PhD in Computer Science',
                'specialization' => 'Information Systems Forensics',
                'experience' => 15,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Dr. Jabhera Matogoro', 
                'email' => 'jabhera.matogoro@udom.ac.tz',
                'employee_id' => 'EMP002',
                'qualification' => 'PhD in Computer Science',
                'specialization' => 'Blockchain Technology',
                'experience' => 12,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Dr. Christina Muro', 
                'email' => 'christina.muro@udom.ac.tz',
                'employee_id' => 'EMP003',
                'qualification' => 'PhD in Computer Science',
                'specialization' => 'Semantic Web and Social Networks',
                'experience' => 10,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Mr. Wilbard Masue', 
                'email' => 'wilbard.masue@udom.ac.tz',
                'employee_id' => 'EMP004',
                'qualification' => 'MSc in Information Security',
                'specialization' => 'Ethical Hacking',
                'experience' => 8,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Dr. Nima Shidende', 
                'email' => 'nima.shidende@udom.ac.tz',
                'employee_id' => 'EMP005',
                'qualification' => 'PhD in Information Security',
                'specialization' => 'Trust Management in E-Commerce',
                'experience' => 14,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Dr. Majuto Manyilizu', 
                'email' => 'majuto.manyilizu@udom.ac.tz',
                'employee_id' => 'EMP006',
                'qualification' => 'PhD in Information Systems',
                'specialization' => 'Business Continuity and Disaster Recovery',
                'experience' => 16,
                'department' => 'Computer Science'
            ],
            [
                'name' => 'Ms. Zubeda Kilua', 
                'email' => 'zubeda.kilua@udom.ac.tz',
                'employee_id' => 'EMP007',
                'qualification' => 'MSc in Network Security',
                'specialization' => 'Wireless Security',
                'experience' => 6,
                'department' => 'Computer Science'
            ],
        ];

        foreach ($teachers as $teacherData) {
            // Create user first
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => bcrypt('password'),
                'school_id' => 1,
                'email_verified_at' => now()
            ]);

            // Create teacher record
            \App\Models\Teacher::create([
                'user_id' => $user->id,
                'school_id' => 1,
                'employee_id' => $teacherData['employee_id'],
                'joining_date' => Carbon::now()->subYears(rand(1, 5))->format('Y-m-d'),
                'qualification' => $teacherData['qualification'],
                'specialization' => $teacherData['specialization'],
                'experience' => $teacherData['experience'],
                'department' => $teacherData['department'],
                'is_class_teacher' => false,
                'status' => true,
            ]);
        }

        // Create sample classes based on the PDF timetable
        $classSchedules = [
            // Monday
            [
                'subject_code' => 'IA 429',
                'type' => 'Practical',
                'teacher' => 'Dr. Salehe Mrutu',
                'day' => 'monday',
                'start_time' => '07:30',
                'end_time' => '09:30',
                'room' => 'ELE_LAB'
            ],
            [
                'subject_code' => 'CG 322',
                'type' => 'Tutorial',
                'teacher' => 'Dr. Jabhera Matogoro',
                'day' => 'monday',
                'start_time' => '11:30',
                'end_time' => '12:30',
                'room' => 'LRA 021'
            ],
            
            // Tuesday
            [
                'subject_code' => 'CS 427',
                'type' => 'Lecture',
                'teacher' => 'Dr. Christina Muro',
                'day' => 'tuesday',
                'start_time' => '11:30',
                'end_time' => '13:30',
                'room' => 'LRB 004D'
            ],
            [
                'subject_code' => 'CS 427',
                'type' => 'Practical',
                'teacher' => 'Dr. Christina Muro',
                'day' => 'tuesday',
                'start_time' => '13:30',
                'end_time' => '15:30',
                'room' => 'ELE_LAB'
            ],
            [
                'subject_code' => 'IA 422',
                'type' => 'Practical',
                'teacher' => 'Mr. Wilbard Masue',
                'day' => 'tuesday',
                'start_time' => '16:00',
                'end_time' => '17:00',
                'room' => 'NET_LAB'
            ],
            [
                'subject_code' => 'IA 428',
                'type' => 'Lecture',
                'teacher' => 'Dr. Nima Shidende',
                'day' => 'tuesday',
                'start_time' => '17:30',
                'end_time' => '19:30',
                'room' => 'LRB 004D'
            ],
            
            // Wednesday
            [
                'subject_code' => 'IA 423',
                'type' => 'Lecture',
                'teacher' => 'Ms. Zubeda Kilua',
                'day' => 'wednesday',
                'start_time' => '09:30',
                'end_time' => '11:30',
                'room' => 'LRB 005B'
            ],
            [
                'subject_code' => 'IA 422',
                'type' => 'Lecture',
                'teacher' => 'Mr. Wilbard Masue',
                'day' => 'wednesday',
                'start_time' => '13:30',
                'end_time' => '15:30',
                'room' => 'LRB 102'
            ],
            
            // Thursday
            [
                'subject_code' => 'IA 421',
                'type' => 'Practical',
                'teacher' => 'Dr. Majuto Manyilizu',
                'day' => 'thursday',
                'start_time' => '09:30',
                'end_time' => '11:30',
                'room' => 'LRB 004D'
            ],
            [
                'subject_code' => 'CG 322',
                'type' => 'Lecture',
                'teacher' => 'Dr. Jabhera Matogoro',
                'day' => 'thursday',
                'start_time' => '13:30',
                'end_time' => '15:30',
                'room' => 'LRB 003D'
            ],
            
            // Friday
            [
                'subject_code' => 'IA 429',
                'type' => 'Lecture',
                'teacher' => 'Dr. Salehe Mrutu',
                'day' => 'friday',
                'start_time' => '09:30',
                'end_time' => '11:30',
                'room' => 'LRB 101'
            ],
            [
                'subject_code' => 'CG 322',
                'type' => 'Practical',
                'teacher' => 'Dr. Jabhera Matogoro',
                'day' => 'friday',
                'start_time' => '11:30',
                'end_time' => '13:30',
                'room' => 'SE_LAB'
            ],
        ];

        foreach ($classSchedules as $schedule) {
            $subject = Subject::where('code', $schedule['subject_code'])->first();
            $teacher = User::where('name', $schedule['teacher'])->first();
            $room = Room::where('name', $schedule['room'])->first();

            if ($subject && $teacher && $room) {
                Classes::create([
                    'school_id' => 1,
                    'academic_year_id' => $academicYear->id,
                    'subject_id' => $subject->id,
                    'grade_id' => $gradeLevel->id,
                    'section_id' => $section->id,
                    'teacher_id' => $teacher->id,
                    'room_id' => $room->id,
                    'class_days' => [$schedule['day']],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'max_capacity' => 50,
                    'current_enrollment' => rand(25, 45),
                    'status' => '1'
                ]);
            }
        }

        // Create sample general schedule activities
        $generalActivities = [
            [
                'day_of_week' => 'monday',
                'activity' => 'Morning Assembly',
                'start_time' => '07:00',
                'end_time' => '07:30',
                'description' => 'Weekly morning assembly for all students'
            ],
            [
                'day_of_week' => 'tuesday',
                'activity' => 'Tea Break',
                'start_time' => '10:30',
                'end_time' => '11:00',
                'description' => 'Morning tea break'
            ],
            [
                'day_of_week' => 'wednesday',
                'activity' => 'Lunch Break',
                'start_time' => '12:30',
                'end_time' => '13:30',
                'description' => 'Lunch break for all students and staff'
            ],
            [
                'day_of_week' => 'thursday',
                'activity' => 'Sports Activities',
                'start_time' => '16:00',
                'end_time' => '18:00',
                'description' => 'Extracurricular sports activities'
            ],
            [
                'day_of_week' => 'friday',
                'activity' => 'Weekly Cleaning',
                'start_time' => '15:00',
                'end_time' => '16:00',
                'description' => 'Weekly campus cleaning activity'
            ],
        ];

        foreach ($generalActivities as $activity) {
            SchoolGeneralSchedule::create([
                'school_id' => 1,
                'academic_year_id' => $academicYear->id,
                'day_of_week' => $activity['day_of_week'],
                'activity' => $activity['activity'],
                'start_time' => $activity['start_time'],
                'end_time' => $activity['end_time'],
                'description' => $activity['description'],
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }
    }
}