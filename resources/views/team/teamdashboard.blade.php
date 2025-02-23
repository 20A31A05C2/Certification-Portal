@extends('layouts.teamsidebar')

@section('title', 'Verification Dashboard')

@section('content')
<div class="p-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 flex items-center justify-center rounded-xl mb-4">
                <i class="fas fa-certificate text-xl"></i>
            </div>
            <h3 class="text-2xl text-gray-800 mb-2">{{ $totalSubmissions }}</h3>
            <p class="text-gray-600 text-sm">Total Submissions</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 bg-yellow-50 text-yellow-600 flex items-center justify-center rounded-xl mb-4">
                <i class="fas fa-hourglass-half text-xl"></i>
            </div>
            <h3 class="text-2xl text-gray-800 mb-2">{{ $pendingCount }}</h3>
            <p class="text-gray-600 text-sm">Pending Verifications</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 bg-green-50 text-green-600 flex items-center justify-center rounded-xl mb-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <h3 class="text-2xl text-gray-800 mb-2">{{ $verifiedCount }}</h3>
            <p class="text-gray-600 text-sm">Verified Certificates</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 bg-red-50 text-red-600 flex items-center justify-center rounded-xl mb-4">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
            <h3 class="text-2xl text-gray-800 mb-2">{{ $rejectedCount }}</h3>
            <p class="text-gray-600 text-sm">Rejected Certificates</p>
        </div>
    </div>

    <!-- Assigned Certificates Section -->
    @if(!empty($assignedCertifications))
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-2">Your Assigned Certifications</h3>
        <div class="flex gap-2 flex-wrap">
            @foreach($assignedCertifications as $cert)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ is_array($cert) ? $cert['name'] : $cert }}
                </span>
            @endforeach
        </div>
    </div>
    @endif
    <!-- Success Message -->
@endsection