<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    public function dashboard()
    {
        $faculty = Auth::user();
        $sections = $faculty->sections()->with(['course', 'classroom'])->get();
        
        return view('faculty.dashboard', compact('sections'));
    }

    public function section($id)
    {
        $section = Section::with(['course', 'classroom', 'schedules'])->findOrFail($id);
        
        // Check if this faculty owns this section
        if ($section->faculty_id !== Auth::id()) {
            abort(403);
        }

        $pendingEnrollments = $section->enrollments()
                                    ->with('student')
                                    ->where('status', 'pending')
                                    ->get();
        
        $approvedEnrollments = $section->enrollments()
                                     ->with(['student', 'grade'])
                                     ->where('status', 'approved')
                                     ->get();

        return view('faculty.section', compact('section', 'pendingEnrollments', 'approvedEnrollments'));
    }

    public function approveStudent(Request $request, $enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $section = $enrollment->section;

        // Check if faculty owns this section
        if ($section->faculty_id !== Auth::id()) {
            abort(403);
        }

        // Check if section is full
        if ($section->enrolled_students >= $section->max_students) {
            return redirect()->back()->with('error', 'Section is full!');
        }

        $enrollment->update(['status' => 'approved']);
        $section->increment('enrolled_students');

        // Create grade record
        Grade::create([
            'enrollment_id' => $enrollment->id,
            'is_graded' => false
        ]);

        return redirect()->back()->with('success', 'Student approved successfully!');
    }

    public function rejectStudent($enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        
        // Check if faculty owns this section
        if ($enrollment->section->faculty_id !== Auth::id()) {
            abort(403);
        }

        $enrollment->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Student rejected.');
    }

    public function gradeStudent(Request $request, $gradeId)
    {
        $request->validate([
            'grade' => 'required',
            'points' => 'required|numeric|min:0|max:4',
            'comments' => 'nullable'
        ]);

        $grade = Grade::findOrFail($gradeId);
        
        // Check if faculty owns this section
        if ($grade->enrollment->section->faculty_id !== Auth::id()) {
            abort(403);
        }

        $grade->update([
            'grade' => $request->grade,
            'points' => $request->points,
            'comments' => $request->comments,
            'is_graded' => true
        ]);

        return redirect()->back()->with('success', 'Grade updated successfully!');
    }
}