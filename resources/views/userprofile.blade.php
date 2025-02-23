@extends('layouts.sidebar')

@section('title', 'Profile')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <!-- Alert Messages -->
    <div class="space-y-4 mb-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-gray-50 p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h3 class="text-lg sm:text-xl text-gray-800 font-semibold m-0">Profile Information</h3>
                <span class="px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs font-semibold bg-blue-50 text-indigo-700">Personal Details</span>
            </div>
            <div class="p-4 sm:p-6">
                <form action="{{ route('userprofile') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="userid" class="block mb-2 text-sm text-gray-600">User ID</label>
                                <input type="text" id="userid" name="userid" 
                                       value="{{ old('userid', auth()->user()->userid) }}" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                       readonly>
                            </div>
                            <div>
                                <label for="username" class="block mb-2 text-sm text-gray-600">Username</label>
                                <input type="text" id="username" name="username" 
                                       value="{{ old('username', auth()->user()->username) }}" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                @error('username')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm text-gray-600">Email Address</label>
                            <input type="email" id="email" name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            @error('email')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Academic Information -->
                        <div class="pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-4">Academic Details</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="batchyear" class="block mb-2 text-sm text-gray-600">Batch Year</label>
                                    <input type="text" id="batchyear" name="batchyear" 
                                           value="{{ old('batchyear', auth()->user()->batchyear) }}" 
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    @error('batchyear')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="branch" class="block mb-2 text-sm text-gray-600">Branch</label>
                                    <input type="text" id="branch" name="branch" 
                                           value="{{ old('branch', auth()->user()->branch) }}" 
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    @error('branch')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="specialization" class="block mb-2 text-sm text-gray-600">Specialization</label>
                                <input type="text" id="specialization" name="specialization" 
                                       value="{{ old('specialization', auth()->user()->specialization) }}" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                @error('specialization')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition-colors gap-2">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Section -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Password Change Card -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h3 class="text-lg sm:text-xl text-gray-800 font-semibold m-0">Security Settings</h3>
                    <span class="px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs font-semibold bg-blue-50 text-indigo-700">Password</span>
                </div>
                <div class="p-4 sm:p-6">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block mb-2 text-sm text-gray-600">Current Password</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                @error('current_password')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password" class="block mb-2 text-sm text-gray-600">New Password</label>
                                <input type="password" id="new_password" name="new_password" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                @error('new_password')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block mb-2 text-sm text-gray-600">Confirm Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            </div>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors gap-2">
                                <i class="fas fa-lock"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h3 class="text-lg sm:text-xl text-gray-800 font-semibold m-0">Danger Zone</h3>
                    <span class="px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs font-semibold bg-red-50 text-red-700">Warning</span>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-4 mb-6 bg-red-50 border border-red-200 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl sm:text-2xl"></i>
                        <p class="text-red-600 text-sm sm:text-base">Once you delete your account, there is no going back. Please be certain.</p>
                    </div>
                    <form action="{{ route('profile.delete') }}" method="POST" 
                          onsubmit="return confirm('Are you absolutely sure you want to delete your account?');">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors gap-2">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection