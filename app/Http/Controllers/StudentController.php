<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $enrollments = $student->enrollments()->with(['section.course', 'section.faculty', 'grade'])->get();
        
        return view('student.dashboard', compact('enrollments'));
    }

    public function courses()
    {
        $sections = Section::with(['course', 'faculty', 'classroom', 'schedules'])
                          ->where('enrolled_students', '<', 60)
                          ->get();
        
        $studentEnrollments = Auth::user()->enrollments()->pluck('section_id')->toArray();
        
        return view('student.courses', compact('sections', 'studentEnrollments'));
    }

    public function requestCourse(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id'
        ]);

        $existingEnrollment = Enrollment::where('student_id', Auth::id())
                                      ->where('section_id', $request->section_id)
                                      ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'You have already requested this course!');
        }

        Enrollment::create([
            'student_id' => Auth::id(),
            'section_id' => $request->section_id,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Course request submitted successfully!');
    }

    public function grades()
    {
        $enrollments = Auth::user()->enrollments()
                          ->with(['section.course', 'grade'])
                          ->where('status', 'approved')
                          ->get();
        
        return view('student.grades', compact('enrollments'));
    }

    public function classrooms()
    {
        $schedules = Schedule::with(['section.course', 'section.classroom'])
                           ->orderBy('day_of_week')
                           ->orderBy('start_time')
                           ->get();
        
        $classrooms = Classroom::all();
        
        return view('student.classrooms', compact('schedules', 'classrooms'));
    }
}