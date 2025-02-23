<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .soft-gradient {
            background: linear-gradient(135deg, #e6f3ff 0%, #ffffff 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center soft-gradient p-6">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8 space-y-6">
            <!-- Header -->
            <div class="text-center space-y-2">
                <div class="inline-block p-3 rounded-full bg-blue-500 mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-blue-600">Welcome Back</h2>
                <p class="text-gray-600">Sign in to your account</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- UserID Field -->
                <div class="space-y-2">
                    <label for="userid" class="text-sm font-medium text-gray-700 block">User ID</label>
                    <div class="relative">
                        <input 
                            type="text"
                            id="userid"
                            name="userid"
                            value="{{ old('userid') }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                            placeholder="Enter your user ID"
                        >
                    </div>
                    @error('userid')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-gray-700 block">Password</label>
                    <div class="relative">
                        <input 
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                            placeholder="Enter your password"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="passwordToggleIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>
                    <a href="{{route('user.forgot')}}" class="text-blue-600 hover:text-blue-700 font-medium">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Sign In
                </button>

                <!-- Sign Up Link -->
                <div class="text-center space-y-4">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ url('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create Account</a>
                    </p>
                    <p class="text-sm text-gray-500">
                        By signing in, you agree to our 
                        <a href="#" class="text-blue-600 hover:text-blue-700">Terms</a> 
                        and 
                        <a href="#" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-600 text-sm">
            © 2024 Your Company. All rights reserved.
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                password.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const userid = document.getElementById('userid').value;
            const password = document.getElementById('password').value;
            let isValid = true;

            if (!userid) {
                isValid = false;
                document.getElementById('userid').classList.add('border-red-500');
            } else {
                document.getElementById('userid').classList.remove('border-red-500');
            }

            if (!password) {
                isValid = false;
                document.getElementById('password').classList.add('border-red-500');
            } else {
                document.getElementById('password').classList.remove('border-red-500');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Remove error styling on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    </script>
</body>
</html>