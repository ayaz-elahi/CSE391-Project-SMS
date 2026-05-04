<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Sample Faculty
        User::create([
            'name' => 'Dr. John Smith',
            'email' => 'faculty@test.com',
            'password' => Hash::make('password123'),
            'role' => 'faculty',
            'faculty_id' => 'FAC001',
        ]);

        User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah@test.com',
            'password' => Hash::make('password123'),
            'role' => 'faculty',
            'faculty_id' => 'FAC002',
        ]);

        // Create Sample Student
        User::create([
            'name' => 'Jane Doe',
            'email' => 'student@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'student_id' => 'STU001',
        ]);

        User::create([
            'name' => 'Mike Wilson',
            'email' => 'mike@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'student_id' => 'STU002',
        ]);

        // Create Sample Courses
        Course::create([
            'course_code' => 'CS101',
            'course_name' => 'Introduction to Computer Science',
            'description' => 'Basic concepts of computer science and programming',
            'credits' => 3,
        ]);

        Course::create([
            'course_code' => 'MATH201',
            'course_name' => 'Calculus I',
            'description' => 'Differential and integral calculus',
            'credits' => 4,
        ]);

        Course::create([
            'course_code' => 'ENG101',
            'course_name' => 'English Composition',
            'description' => 'Academic writing and communication skills',
            'credits' => 3,
        ]);

        // Create Sample Classrooms
        Classroom::create([
            'room_number' => 'A101',
            'building' => 'Academic Building A',
            'capacity' => 60,
        ]);

        Classroom::create([
            'room_number' => 'B205',
            'building' => 'Science Building',
            'capacity' => 45,
        ]);

        Classroom::create([
            'room_number' => 'C301',
            'building' => 'Liberal Arts Building',
            'capacity' => 50,
        ]);
    }
}