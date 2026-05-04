@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Course Management</h1>
    <p class="text-gray-600">Add and manage courses</p>
</div>

<!-- Add Course Form -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h2 class="text-xl font-semibold mb-4">Add New Course</h2>
    
    <form method="POST" action="{{ route('admin.courses.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
            <input type="text" name="course_code" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
        </div>
        
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Course Name</label>
            <input type="text" name="course_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
        </div>
        
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Credits</label>
            <input type="number" name="credits" min="1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" rows="3"></textarea>
        </div>
        
        <div class="md:col-span-2">
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Add User
            </button>
        </div>
    </form>
</div>

<!-- Users List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Existing Users</h2>
        
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs {{ $user->role === 'student' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $user->student_id ?? $user->faculty_id ?? 'N/A' }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No users found. Add your first user above!</p>
        @endif
    </div>
</div>
@endsection