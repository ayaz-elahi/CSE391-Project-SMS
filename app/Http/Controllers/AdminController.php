<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_faculty' => User::where('role', 'faculty')->count(),
            'total_courses' => Course::count(),
            'total_sections' => Section::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    // Course Management
    public function courses()
    {
        $courses = Course::all();
        return view('admin.courses', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses',
            'course_name' => 'required',
            'credits' => 'required|integer|min:1',
            'description' => 'nullable'
        ]);

        Course::create($request->all());
        return redirect()->back()->with('success', 'Course created successfully!');
    }

    // Section Management
    public function sections()
    {
        $sections = Section::with(['course', 'faculty', 'classroom', 'schedules'])->get();
        $courses = Course::all();
        $faculties = User::where('role', 'faculty')->get();
        $classrooms = Classroom::all();
        
        return view('admin.sections', compact('sections', 'courses', 'faculties', 'classrooms'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'faculty_id' => 'required|exists:users,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_name' => 'required',
            'semester' => 'required',
            'year' => 'required|integer',
            'schedules' => 'required|array',
            'schedules.*.day_of_week' => 'required',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
        ]);

        $section = Section::create($request->except('schedules'));

        foreach ($request->schedules as $schedule) {
            Schedule::create([
                'section_id' => $section->id,
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
            ]);
        }

        return redirect()->back()->with('success', 'Section created successfully!');
    }

    // Classroom Management
    public function classrooms()
    {
        $classrooms = Classroom::all();
        return view('admin.classrooms', compact('classrooms'));
    }

    public function storeClassroom(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:classrooms',
            'building' => 'required',
            'capacity' => 'required|integer|min:1|max:60'
        ]);

        Classroom::create($request->all());
        return redirect()->back()->with('success', 'Classroom created successfully!');
    }

    // User Management
    public function users()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:student,faculty',
            'student_id' => 'required_if:role,student|unique:users,student_id',
            'faculty_id' => 'required_if:role,faculty|unique:users,faculty_id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'student_id' => $request->student_id,
            'faculty_id' => $request->faculty_id,
            'password' => Hash::make('password123'), // Default password
        ]);

        return redirect()->back()->with('success', 'User created successfully! Default password: password123');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}