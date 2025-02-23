<!-- Add this to both login.blade.php and register.blade.php files - just change the title and form content as needed -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-sky-100 via-blue-50 to-white py-10">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <i class="fas fa-user-shield text-4xl text-blue-500 mb-3"></i>
                <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
                <p class="text-gray-500 mt-2">Welcome back! Please login to your account.</p>
            </div>

            <form action="{{route('adlogin.post')}}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-blue-500"></i>
                        </div>
                        <input class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               id="email" 
                               type="email" 
                               name="email" 
                               required 
                               placeholder="Enter your email">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-blue-500"></i>
                        </div>
                        <input class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               id="password" 
                               type="password" 
                               name="password" 
                               required 
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="" class="text-sm text-blue-500 hover:text-blue-600">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2.5 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                    Sign In
                </button>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <span class="text-gray-600">Don't have an account?</span>
                    <a href="{{route('showreg')}}" class="text-blue-500 hover:text-blue-600 ml-1 font-medium">Register here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>