<!-- resources/views/dashboard/profile.blade.php -->
@extends('layouts.teamsidebar')

@section('title', 'Profile')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="space-y-4">
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-gray-50 p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl text-gray-800 font-semibold m-0">Profile Information</h3>
                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-blue-50 text-indigo-700">Personal Details</span>
            </div>
            <div class="p-6">
            <form action="{{route('updateteam.Profile')}}" method="POST">
             @csrf
            <div class="space-y-6">
            <div>
            <label for="username" class="block mb-2 text-sm text-gray-600">New Username</label>
            <input type="text" id="username" name="username"
            value="{{ old('username', Auth::guard('teams')->user()->username ?? '') }}"
            class="w-full px-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm text-gray-600">New Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email', Auth::guard('teams')->user()->email ?? '') }}"
                class="w-full px-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition-colors gap-2">
            <i class="fas fa-save"></i> Update Profile
        </button>
        </div>
        </form>
            </div>
        </div>

        <!-- Password Change Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-gray-50 p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl text-gray-800 font-semibold m-0">Security Settings</h3>
                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-blue-50 text-indigo-700">Password</span>
            </div>
            <div class="p-6">
            <form action="{{route('updateteam.Password')}}" method="POST">
                     @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="current_password" class="block mb-2 text-sm text-gray-600">Current Password</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full px-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="new_password" class="block mb-2 text-sm text-gray-600">New Password</label>
                            <input type="password" id="new_password" name="new_password" 
                                   class="w-full px-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            @error('new_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block mb-2 text-sm text-gray-600">Confirm Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                   class="w-full px-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors gap-2">
                            <i class="fas fa-lock"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-gray-50 p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl text-gray-800 font-semibold m-0">Danger Zone</h3>
                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-red-50 text-red-700">Warning</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 p-4 mb-6 bg-red-50 border border-red-200 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    <p class="text-red-600">Once you delete your account, there is no going back. Please be certain.</p>
                </div>
                <form action="{{route('team.delete')}}" method="POST" 
                      onsubmit="return confirm('Are you absolutely sure you want to delete your account?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors gap-2">
                        <i class="fas fa-trash"></i> Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection