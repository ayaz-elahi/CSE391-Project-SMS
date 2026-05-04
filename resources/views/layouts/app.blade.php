<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold">SMS</h1>
                    <span class="ml-4 text-indigo-200">Student Management System</span>
                </div>
                
                <!-- User Menu (when authenticated) -->
                <div class="flex items-center space-x-4">
                    <!-- This would be populated with user info and logout -->
                    <span class="text-indigo-200">Welcome, User</span>
                    <button class="bg-indigo-500 hover:bg-indigo-400 px-3 py-2 rounded text-sm">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Secondary Navigation (Role-based) -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex space-x-8 py-3">
                <!-- Admin Navigation -->
                <div class="admin-nav hidden">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-semibold">Dashboard</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Courses</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Sections</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Classrooms</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Users</a>
                </div>
                
                <!-- Faculty Navigation -->
                <div class="faculty-nav hidden">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-semibold">Dashboard</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">My Courses</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Gradebook</a>
                </div>
                
                <!-- Student Navigation -->
                <div class="student-nav">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-semibold">Dashboard</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Browse Courses</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">My Grades</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 ml-8">Classrooms</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        <!-- Success Message -->
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 hidden" id="success-message">
            Success message will appear here
        </div>

        <!-- Error Message -->
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden" id="error-message">
            Error message will appear here
        </div>

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Student Management System</h2>
            <p class="text-gray-600">This is where your page content would go. The navigation is now properly structured and aligned.</p>
            
            <!-- Demo Content -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Students</h3>
                    <p class="text-blue-600">Manage student records</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800">Courses</h3>
                    <p class="text-green-600">Course management</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-800">Reports</h3>
                    <p class="text-purple-600">Generate reports</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>