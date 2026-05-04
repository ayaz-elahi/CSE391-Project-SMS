<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl w-96">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">SMS Login</h1>
            <p class="text-gray-600 mt-2">Student Management System</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                Login
            </button>
        </form>

        <div class="mt-6 text-sm text-gray-600">
            <!-- <p><strong>Demo Accounts:</strong></p>
            <p>Admin: admin@test.com / password123</p>
            <p>Faculty: faculty@test.com / password123</p>
            <p>Student: student@test.com / password123</p> -->
        </div>
    </div>
</body>
</html>