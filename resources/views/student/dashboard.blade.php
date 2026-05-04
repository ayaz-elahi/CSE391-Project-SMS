@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Student Dashboard</h1>
    <p class="text-gray-600">Welcome, {{ Auth::user()->name }}!</p>
</div>

<!-- Quick Navigation -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('student.courses') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Browse Courses</h3>
        <p class="text-blue-100">Request new courses</p>
    </a>
    
    <a href="{{ route('student.grades') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">My Grades</h3>
        <p class="text-green-100">View your grades</p>
    </a>
    
    <a href="{{ route('student.classrooms') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Classrooms</h3>
        <p class="text-purple-100">View room schedules</p>
    </a>
</div>

<!-- My Enrollments -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">My Enrollments</h2>
        
        @if($enrollments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Section</th>
                            <th class="px-4 py-2 text-left">Faculty</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $enrollment->section->course->course_name }}</td>
                            <td class="px-4 py-2">{{ $enrollment->section->section_name }}</td>
                            <td class="px-4 py-2">{{ $enrollment->section->faculty->name }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs
                                    {{ $enrollment->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($enrollment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($enrollment->grade && $enrollment->grade->is_graded)
                                    <span class="font-semibold">{{ $enrollment->grade->grade }} ({{ $enrollment->grade->points }})</span>
                                @else
                                    <span class="text-gray-500">Not graded</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No enrollments found. <a href="{{ route('student.courses') }}" class="text-indigo-600 hover:underline">Browse courses</a> to get started!</p>
        @endif
    </div>
</div>
@endsection