@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Classroom Schedule</h1>
    <p class="text-gray-600">View room occupancy and availability</p>
</div>

<!-- Schedule Table -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Weekly Schedule</h2>
        
        @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Day</th>
                            <th class="px-4 py-2 text-left">Time</th>
                            <th class="px-4 py-2 text-left">Classroom</th>
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Section</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules->groupBy('day_of_week') as $day => $daySchedules)
                            @foreach($daySchedules as $schedule)
                            <tr class="border-b">
                                <td class="px-4 py-2 font-semibold">{{ $day }}</td>
                                <td class="px-4 py-2">{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</td>
                                <td class="px-4 py-2">
                                    <span class="font-semibold">{{ $schedule->section->classroom->room_number }}</span>
                                    <div class="text-sm text-gray-500">{{ $schedule->section->classroom->building }}</div>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="font-semibold">{{ $schedule->section->course->course_name }}</span>
                                    <div class="text-sm text-gray-500">{{ $schedule->section->course->course_code }}</div>
                                </td>
                                <td class="px-4 py-2">{{ $schedule->section->section_name }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No schedules found.</p>
        @endif
    </div>
</div>

<!-- Available Classrooms -->
<div class="bg-white rounded-lg shadow mt-6">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">All Classrooms</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($classrooms as $classroom)
            <div class="border rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $classroom->room_number }}</h3>
                <p class="text-gray-600">Building: {{ $classroom->building }}</p>
                <p class="text-gray-600">Capacity: {{ $classroom->capacity }} students</p>
                
                @php
                    $roomSchedules = $schedules->where('section.classroom_id', $classroom->id);
                @endphp
                
                @if($roomSchedules->count() > 0)
                    <div class="mt-2">
                        <p class="text-sm font-semibold text-red-600">Occupied:</p>
                        @foreach($roomSchedules as $schedule)
                            <div class="text-xs text-gray-500">
                                {{ $schedule->day_of_week }}: {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-green-600 mt-2">Currently Available</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection