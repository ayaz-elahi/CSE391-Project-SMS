@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">My Grades</h1>
    <p class="text-gray-600">View your academic performance</p>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        @if($enrollments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Section</th>
                            <th class="px-4 py-2 text-left">Credits</th>
                            <th class="px-4 py-2 text-left">Grade</th>
                            <th class="px-4 py-2 text-left">Points</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                <div>
                                    <div class="font-semibold">{{ $enrollment->section->course->course_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->section->course->course_code }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $enrollment->section->section_name }}</td>
                            <td class="px-4 py-2">{{ $enrollment->section->course->credits }}</td>
                            <td class="px-4 py-2">
                                @if($enrollment->grade && $enrollment->grade->is_graded)
                                    <span class="font-semibold text-lg">{{ $enrollment->grade->grade }}</span>
                                @else
                                    <span class="text-gray-500">Not graded</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($enrollment->grade && $enrollment->grade->is_graded)
                                    <span class="font-semibold">{{ $enrollment->grade->points }}/4.0</span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($enrollment->grade && $enrollment->grade->is_graded)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Graded</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ $enrollment->grade->comments ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- GPA Calculation -->
            @php
                $totalPoints = 0;
                $totalCredits = 0;
                foreach($enrollments as $enrollment) {
                    if($enrollment->grade && $enrollment->grade->is_graded) {
                        $totalPoints += $enrollment->grade->points * $enrollment->section->course->credits;
                        $totalCredits += $enrollment->section->course->credits;
                    }
                }
                $gpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
            @endphp
            
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold">Academic Summary</h3>
                <p><strong>Current GPA:</strong> <span class="text-2xl font-bold text-indigo-600">{{ $gpa }}/4.0</span></p>
                <p><strong>Total Credits:</strong> {{ $totalCredits }}</p>
            </div>
        @else
            <p class="text-gray-500 text-center">No enrolled courses found. <a href="{{ route('student.courses') }}" class="text-indigo-600 hover:underline">Browse courses</a> to get started!</p>
        @endif
    </div>
</div>
@endsection