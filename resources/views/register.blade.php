<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .soft-gradient {
            background: linear-gradient(135deg, #e6f3ff 0%, #ffffff 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center soft-gradient p-6">
    <div class="w-full max-w-4xl">
        <!-- Registration Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8">
            <!-- Header -->
            <div class="text-center space-y-2 mb-8">
                <div class="inline-block p-3 rounded-full bg-blue-500 mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-blue-600">Create Account</h2>
                <p class="text-gray-600">Sign up for your new account</p>
            </div>

            <!-- Registration Form -->
            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- User ID Field -->
                        <div class="space-y-2">
                            <label for="userid" class="text-sm font-medium text-gray-700 block">Reg ID</label>
                            <input 
                                type="text"
                                id="userid"
                                name="userid"
                                value="{{ old('userid') }}"
                                required
                                maxlength="15"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Choose a Reg ID"
                            >
                        </div>

                        <!-- Username Field -->
                        <div class="space-y-2">
                            <label for="username" class="text-sm font-medium text-gray-700 block">Name</label>
                            <input 
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                maxlength="255"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Choose a Name"
                            >
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700 block">Email Address</label>
                            <input 
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Enter your email"
                            >
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-700 block">Password</label>
                            <div class="relative">
                                <input 
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="5"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                    placeholder="Create a password"
                                >
                                <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-medium text-gray-700 block">Confirm Password</label>
                            <div class="relative">
                                <input 
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                    placeholder="Confirm your password"
                                >
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Details Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Academic Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Batch Year Field -->
                        <div class="space-y-2">
                            <label for="batchyear" class="text-sm font-medium text-gray-700 block">Batch Year</label>
                            <input 
                                type="text"
                                id="batchyear"
                                name="batchyear"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Enter batch year"
                            >
                        </div>

                        <!-- Branch Field -->
                        <div class="space-y-2">
                            <label for="branch" class="text-sm font-medium text-gray-700 block">Branch</label>
                            <input 
                                type="text"
                                id="branch"
                                name="branch"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Enter your branch"
                            >
                        </div>

                        <!-- Specialization Field -->
                        <div class="space-y-2">
                            <label for="specialization" class="text-sm font-medium text-gray-700 block">Specialization</label>
                            <input 
                                type="text"
                                id="specialization"
                                name="specialization"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                                placeholder="Enter specialization"
                            >
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="mt-8">
                    <label class="flex items-center">
                        <input type="checkbox" required class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <span class="ml-2 text-sm text-gray-600">I agree to the Terms and Privacy Policy</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ url('/login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Login</a>
                    </p>
                </div>
            </form>
        </div>


    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            let isValid = true;
            
            // Password validation
            if (password.value !== confirmPassword.value) {
                isValid = false;
                confirmPassword.classList.add('border-red-500');
                showError(confirmPassword, 'Passwords do not match!');
            }

            if (password.value.length < 5) {
                isValid = false;
                password.classList.add('border-red-500');
                showError(password, 'Password must be at least 5 characters long');
            }

            if (!isValid) {
                e.preventDefault();
                return;
            }

            // Show loading state on button
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Creating account...
            `;
        });

        // Show error message function
        function showError(element, message) {
            const errorDiv = document.createElement('p');
            errorDiv.className = 'text-red-500 text-sm mt-1';
            errorDiv.textContent = message;
            
            const existingError = element.parentNode.querySelector('.text-red-500');
            if (existingError) {
                existingError.remove();
            }
            
            element.parentNode.appendChild(errorDiv);
        }

        // Remove error styling and messages on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                const errorMessage = this.parentNode.querySelector('.text-red-500');
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });
    </script>
</body>
</html>