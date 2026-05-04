@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Available Courses</h1>
    <p class="text-gray-600">Browse and request courses</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach($sections as $section)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <h3 class="text-xl font-semibold text-gray-800">{{ $section->course->course_name }}</h3>
            <p class="text-gray-600">{{ $section->course->course_code }} - Section {{ $section->section_name }}</p>
        </div>
        
        <div class="space-y-2 mb-4">
            <p><strong>Faculty:</strong> {{ $section->faculty->name }}</p>
            <p><strong>Classroom:</strong> {{ $section->classroom->room_number }} ({{ $section->classroom->building }})</p>
            <p><strong>Remaining Seats:</strong> 
                <span class="font-semibold {{ $section->remaining_seats > 10 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $section->remaining_seats }}/{{ $section->max_students }}
                </span>
            </p>
            <p><strong>Credits:</strong> {{ $section->course->credits }}</p>
        </div>
        
        <div class="mb-4">
            <h4 class="font-semibold text-gray-700 mb-2">Class Schedule:</h4>
            @foreach($section->schedules as $schedule)
                <div class="text-sm text-gray-600">
                    {{ $schedule->day_of_week }}: {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}
                </div>
            @endforeach
        </div>
        
        @if(in_array($section->id, $studentEnrollments))
            <button class="w-full bg-gray-400 text-white py-2 px-4 rounded cursor-not-allowed" disabled>
                Already Requested
            </button>
        @elseif($section->remaining_seats <= 0)
            <button class="w-full bg-red-400 text-white py-2 px-4 rounded cursor-not-allowed" disabled>
                Section Full
            </button>
        @else
            <form method="POST" action="{{ route('student.request.course') }}">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                    Request Course
                </button>
            </form>
        @endif
    </div>
    @endforeach
</div>

@if($sections->count() === 0)
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-center">No available courses at the moment.</p>
    </div>
@endif
@endsection