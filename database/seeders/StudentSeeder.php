<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $tanzanianMaleFirstNames = ['Emmanuel', 'Joseph', 'John', 'Frank', 'Peter', 'Juma', 'Kelvin', 'David', 'Michael', 'James', 'Amani', 'Baraka'];
        $tanzanianFemaleFirstNames = ['Ally', 'Young', 'Amani', 'Irene', 'Yohana', 'Neema', 'Elly', 'Grace', 'Elisha', 'Elia', 'Lulu', 'Nala'];
        $tanzanianLastNames = ['Moshi', 'Mchunga', 'Komba', 'Mollel', 'Mbwambo', 'Kessy', 'Mmary', 'Kondo', 'Abdallah', 'Kikwete', 'Nyerere', 'Mwalimu'];

        $religions = array_merge(
            array_fill(0, 57, 'Christianity'),
            array_fill(0, 37, 'Islam'),
            array_fill(0, 6, 'Other')
        );

        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['Male', 'Female']);
            $firstName = $gender === 'Male'
                ? $faker->randomElement($tanzanianMaleFirstNames)
                : $faker->randomElement($tanzanianFemaleFirstNames);
            $middleName = $faker->firstName();
            $lastName = $faker->randomElement($tanzanianLastNames);

            $userId = (string) Str::uuid();

            // Create user record for student
            User::create([
                'id' => $userId,
                'name' => "$firstName $lastName",
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'), // You can set a different logic here
                'role' => 'student',
                'status' => 'active',
            ]);

            // Grade & DOB
            $gradeId = GradeLevel::inRandomOrder()->first()->id ?? 1;
            $age = $faker->numberBetween(13, 19);
            $dob = $faker->dateTimeBetween("-$age years", "-" . ($age - 1) . " years")->format('Y-m-d');

            Student::create([
                'user_id' => $userId,
                'admitted_by' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
                'school_id' => 1,
                'admission_number' => 'ADM-' . $faker->unique()->randomNumber(5),
                'fname' => $firstName,
                'mname' => $middleName,
                'lname' => $lastName,
                'admission_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'grade_id' => $gradeId,
                'section_id' => Section::inRandomOrder()->first()->id ?? null,
                'roll_number' => $faker->unique()->randomNumber(3),
                'date_of_birth' => $dob,
                'gender' => $gender,
                'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'religion' => $faker->randomElement($religions),
                'nationality' => 'Tanzanian',
                'is_transport' => $faker->boolean(),
                'is_hostel' => $faker->boolean(),
                'status' => 'active',
                'previous_school_info' => null,
            ]);
        }
    }
}
