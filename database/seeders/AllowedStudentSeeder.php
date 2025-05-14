<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\AllowedStudent;


class AllowedStudentSeeder extends Seeder
{
    public function run(): void
    {
        // Assuming the file is in storage/app/students.json
        $json = File::get(storage_path('app/students.json'));
        $students = json_decode($json, true);

        foreach ($students as $student) {
            \App\Models\AllowedStudent::updateOrCreate(
                ['student_id' => $student['student_id']], // Unique student ID to avoid duplicates
                [
                    'first_name' => $student['first_name'],
                    'last_name' => $student['last_name'],
                    'is_registered' => false, // Default to false
                ]
            );
        }
    }
}
