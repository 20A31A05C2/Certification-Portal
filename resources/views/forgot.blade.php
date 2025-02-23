<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Modern Design</title>
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
        <!-- Reset Password Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8 space-y-6">
            <!-- Header -->
            <div class="text-center space-y-2">
                <div class="inline-block p-3 rounded-full bg-blue-500 mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-blue-600">Set New Password</h2>
                <p class="text-gray-600">Create a strong password for your account</p>
            </div>

            <!-- Reset Form -->
            <form id="newPasswordForm" action="" method="POST" class="space-y-6">
                @csrf
                <!-- New Password Field -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-gray-700 block">New Password</label>
                    <div class="relative">
                        <input 
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 outline-none"
                            placeholder="Enter new password"
                        >
                        <button type="button" onclick="togglePassword('password', 'passwordToggleIcon')" class="absolute right-3 top-1/2 -translate-y-1/2">
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
                            placeholder="Confirm new password"
                        >
                        <button type="button" onclick="togglePassword('password_confirmation', 'confirmToggleIcon')" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="confirmToggleIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="text-sm text-gray-500 space-y-1">
                    <p>Password must contain:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>At least 8 characters</li>
                        <li>At least one uppercase letter</li>
                        <li>At least one number</li>
                        <li>At least one special character</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Reset Password
                </button>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form validation
        document.getElementById('newPasswordForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            let isValid = true;

            // Password validation
            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            
            if (!passwordRegex.test(password)) {
                isValid = false;
                document.getElementById('password').classList.add('border-red-500');
            } else {
                document.getElementById('password').classList.remove('border-red-500');
            }

            // Confirmation validation
            if (password !== confirmation) {
                isValid = false;
                document.getElementById('password_confirmation').classList.add('border-red-500');
            } else {
                document.getElementById('password_confirmation').classList.remove('border-red-500');
            }

            if (!isValid) {
                e.preventDefault();
                // Show error message
                if (!document.querySelector('.error-message')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-red-500 text-sm mt-2 error-message';
                    errorDiv.textContent = 'Please check password requirements and ensure passwords match.';
                    document.querySelector('button[type="submit"]').insertAdjacentElement('beforebegin', errorDiv);
                }
            }
        });

        // Remove error styling on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                const errorMessage = document.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });
    </script>
</body>
</html>