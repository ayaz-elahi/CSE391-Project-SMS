@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Faculty Dashboard</h1>
    <p class="text-gray-600">Welcome, {{ Auth::user()->name }}!</p>
</div>

<!-- My Sections -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">My Sections</h2>
        
        @if($sections->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($sections as $section)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $section->course->course_name }}</h3>
                    <p class="text-gray-600 mb-2">{{ $section->course->course_code }} - Section {{ $section->section_name }}</p>
                    
                    <div class="space-y-1 text-sm text-gray-600 mb-4">
                        <p><strong>Classroom:</strong> {{ $section->classroom->room_number }} ({{ $section->classroom->building }})</p>
                        <p><strong>Enrollment:</strong> {{ $section->enrolled_students }}/{{ $section->max_students }}</p>
                        <p><strong>Semester:</strong> {{ $section->semester }} {{ $section->year }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-semibold text-sm text-gray-700 mb-1">Schedule:</h5>
                        @foreach($section->schedules as $schedule)
                            <div class="text-xs text-gray-500">
                                {{ $schedule->day_of_week }}: {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}
                            </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('faculty.section', $section->id) }}" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded inline-block text-center">
                        Manage Section
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No sections assigned to you yet.</p>
        @endif
    </div>
</div>
@endsection