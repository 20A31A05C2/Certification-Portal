<!-- resources/views/dashboard.blade.php -->
@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mt-4 sm:mt-6 mb-6 px-2 sm:px-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Dashboard Overview</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 p-2 sm:p-0 mb-8">
        <!-- Total Certifications -->
        <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 text-blue-600 flex items-center justify-center rounded-xl mb-3 sm:mb-4">
                <i class="fas fa-certificate text-lg sm:text-xl"></i>
            </div>
            <div class="flex flex-row sm:flex-col justify-between sm:justify-start items-center sm:items-start">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-0 sm:mb-2">{{ $totalCertificates }}</h3>
                <p class="text-gray-600 text-sm">Total Certifications</p>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 text-green-600 flex items-center justify-center rounded-xl mb-3 sm:mb-4">
                <i class="fas fa-clock text-lg sm:text-xl"></i>
            </div>
            <div class="flex flex-row sm:flex-col justify-between sm:justify-start items-center sm:items-start">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-0 sm:mb-2">{{ $pendingCertificates }}</h3>
                <p class="text-gray-600 text-sm">Pending Reviews</p>
            </div>
        </div>

        <!-- Verified Certifications -->
        <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-50 text-purple-600 flex items-center justify-center rounded-xl mb-3 sm:mb-4">
                <i class="fas fa-check-circle text-lg sm:text-xl"></i>
            </div>
            <div class="flex flex-row sm:flex-col justify-between sm:justify-start items-center sm:items-start">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-0 sm:mb-2">{{ $verifiedCertificates }}</h3>
                <p class="text-gray-600 text-sm">Verified Certifications</p>
            </div>
        </div>

        <!-- Rejected Certifications -->
        <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-50 text-red-600 flex items-center justify-center rounded-xl mb-3 sm:mb-4">
                <i class="fas fa-times-circle text-lg sm:text-xl"></i>
            </div>
            <div class="flex flex-row sm:flex-col justify-between sm:justify-start items-center sm:items-start">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-0 sm:mb-2">{{ $rejectedCertificates }}</h3>
                <p class="text-gray-600 text-sm">Rejected Certifications</p>
            </div>
        </div>
    </div>

    <!-- User Details Section -->
<div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 lg:p-8 mb-8">
    <!-- Header with Edit Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-100">
        <div class="mb-4 sm:mb-0">
            <h2 class="text-xl font-semibold text-gray-800">User Information</h2>
            <p class="text-sm text-gray-500 mt-1">View and manage your profile details</p>
        </div>
        <a href="{{ route('userprofile') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
            <i class="fas fa-edit mr-2"></i>
            Edit Profile
        </a>
    </div>

    <!-- User Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- User ID -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">User ID</label>
                <p class="text-gray-800 font-medium">{{ $user->userid }}</p>
            </div>

            <!-- Username -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">Username</label>
                <p class="text-gray-800 font-medium">{{ $user->username }}</p>
            </div>

            <!-- Email -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">Email Address</label>
                <p class="text-gray-800 font-medium break-all">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Batch Year -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">Batch Year</label>
                <p class="text-gray-800 font-medium">{{ $user->batchyear }}</p>
            </div>

            <!-- Branch -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">Branch</label>
                <p class="text-gray-800 font-medium">{{ $user->branch }}</p>
            </div>

            <!-- Specialization -->
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="text-sm font-medium text-gray-500 block mb-1">Specialization</label>
                <p class="text-gray-800 font-medium">{{ $user->specialization }}</p>
            </div>
        </div>
    </div>
</div>
@endsection