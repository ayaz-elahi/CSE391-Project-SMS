@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
    <p class="text-gray-600">Manage your educational institution</p>
</div>

<!-- Quick Navigation -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.courses') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Courses</h3>
        <p class="text-blue-100">Manage Courses</p>
    </a>
    
    <a href="{{ route('admin.sections') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Sections</h3>
        <p class="text-green-100">Manage Sections</p>
    </a>
    
    <a href="{{ route('admin.classrooms') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Classrooms</h3>
        <p class="text-purple-100">Manage Classrooms</p>
    </a>
    
    <a href="{{ route('admin.users') }}" class="bg-red-500 hover:bg-red-600 text-white p-6 rounded-lg">
        <h3 class="text-lg font-semibold">Users</h3>
        <p class="text-red-100">Manage Users</p>
    </a>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">Total Students</h3>
        <p class="text-3xl font-bold text-blue-500">{{ $stats['total_students'] }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">Total Faculty</h3>
        <p class="text-3xl font-bold text-green-500">{{ $stats['total_faculty'] }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">Total Courses</h3>
        <p class="text-3xl font-bold text-purple-500">{{ $stats['total_courses'] }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">Total Sections</h3>
        <p class="text-3xl font-bold text-red-500">{{ $stats['total_sections'] }}</p>
    </div>
</div>
@endsection