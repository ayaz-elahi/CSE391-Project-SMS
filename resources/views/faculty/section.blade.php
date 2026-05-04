@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">{{ $section->course->course_name }}</h1>
    <p class="text-gray-600">{{ $section->course->course_code }} - Section {{ $section->section_name }}</p>
</div>

<!-- Section Info -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Section Information</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <p><strong>Classroom:</strong> {{ $section->classroom->room_number }} ({{ $section->classroom->building }})</p>
            <p><strong>Capacity:</strong> {{ $section->max_students }} students</p>
        </div>
        <div>
            <p><strong>Enrolled:</strong> {{ $section->enrolled_students }}</p>
            <p><strong>Semester:</strong> {{ $section->semester }} {{ $section->year }}</p>
        </div>
        <div>
            <h4 class="font-semibold">Schedule:</h4>
            @foreach($section->schedules as $schedule)
                <div class="text-sm">{{ $schedule->day_of_week }}: {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pending Requests -->
@if($pendingEnrollments->count() > 0)
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Pending Enrollment Requests</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Student Name</th>
                    <th class="px-4 py-2 text-left">Student ID</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Request Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingEnrollments as $enrollment)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $enrollment->student->name }}</td>
                    <td class="px-4 py-2">{{ $enrollment->student->student_id }}</td>
                    <td class="px-4 py-2">{{ $enrollment->student->email }}</td>
                    <td class="px-4 py-2">{{ $enrollment->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('faculty.approve.student', $enrollment->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('faculty.reject.student', $enrollment->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Are you sure?')">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Enrolled Students -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Enrolled Students</h2>
    
    @if($approvedEnrollments->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left">Student Name</th>
                        <th class="px-4 py-2 text-left">Student ID</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Grade</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvedEnrollments as $enrollment)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $enrollment->student->name }}</td>
                        <td class="px-4 py-2">{{ $enrollment->student->student_id }}</td>
                        <td class="px-4 py-2">{{ $enrollment->student->email }}</td>
                        <td class="px-4 py-2">
                            @if($enrollment->grade && $enrollment->grade->is_graded)
                                <span class="font-semibold">{{ $enrollment->grade->grade }} ({{ $enrollment->grade->points }})</span>
                            @else
                                <span class="text-gray-500">Not graded</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <button onclick="openGradeModal({{ $enrollment->grade->id }}, '{{ $enrollment->student->name }}', '{{ $enrollment->grade->grade ?? '' }}', '{{ $enrollment->grade->points ?? '' }}', '{{ $enrollment->grade->comments ?? '' }}')" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                {{ $enrollment->grade && $enrollment->grade->is_graded ? 'Update Grade' : 'Add Grade' }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No students enrolled yet.</p>
    @endif
</div>

<!-- Grade Modal -->
<div id="gradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Grade Student</h3>
        
        <form id="gradeForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Student</label>
                <input type="text" id="studentName" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Grade</label>
                <select name="grade" id="gradeSelect" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                    <option value="">Select Grade</option>
                    <option value="A+">A+</option>
                    <option value="A">A</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B">B</option>
                    <option value="B-">B-</option>
                    <option value="C+">C+</option>
                    <option value="C">C</option>
                    <option value="C-">C-</option>
                    <option value="D+">D+</option>
                    <option value="D">D</option>
                    <option value="F">F</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Points (0-4)</label>
                <input type="number" name="points" id="pointsInput" step="0.01" min="0" max="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Comments</label>
                <textarea name="comments" id="commentsInput" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" rows="3"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeGradeModal()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Save Grade
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openGradeModal(gradeId, studentName, grade, points, comments) {
    document.getElementById('gradeModal').classList.remove('hidden');
    document.getElementById('gradeForm').action = `/faculty/grade-student/${gradeId}`;
    document.getElementById('studentName').value = studentName;
    document.getElementById('gradeSelect').value = grade;
    document.getElementById('pointsInput').value = points;
    document.getElementById('commentsInput').value = comments;
}

function closeGradeModal() {
    document.getElementById('gradeModal').classList.add('hidden');
}
</script>
@endsection