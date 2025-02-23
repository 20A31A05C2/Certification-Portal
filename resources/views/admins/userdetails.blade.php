
@extends('layouts.adminsidebar')

@section('title', 'User Details')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-2 sm:py-4">
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <!-- Header with enhanced mobile spacing -->
        <div class="p-3 sm:p-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-0 sm:justify-between">
                <h1 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900">User Details</h1>
                <a href="{{ url('/admin/adminusers') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-3 sm:p-5 space-y-4 sm:space-y-6">
            <!-- User Information Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <!-- Student Information Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-3 sm:p-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900">Student Information</h3>
                        </div>
                        <div class="p-3 sm:p-4">
                            <dl class="grid gap-2 sm:gap-3">
                                @foreach([
                                    'Regid' => $user->userid,
                                    'Name' => $user->username,
                                    'Email' => $user->email,
                                    'Joined' => $user->created_at->format('M d, Y')
                                ] as $label => $value)
                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-600">{{ $label }}</dt>
                                        <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>

                    <!-- Academic Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-3 sm:p-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900">Academic Details</h3>
                        </div>
                        <div class="p-3 sm:p-4">
                            <dl class="grid gap-2 sm:gap-3">
                                @foreach([
                                    'Batch' => $user->batchyear ?? 'N/A',
                                    'Branch' => $user->branch ?? 'N/A',
                                    'Specialization' => $user->specialization ?? 'N/A'
                                ] as $label => $value)
                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-600">{{ $label }}</dt>
                                        <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- Statistics Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-3 sm:p-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900">Certification Statistics</h3>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <div class="bg-blue-50 rounded-lg p-2.5 sm:p-4">
                                    <p class="text-xs sm:text-sm font-medium text-blue-700">Total</p>
                                    <p class="mt-1 text-xl sm:text-2xl lg:text-3xl font-semibold text-blue-900">{{ $totalCertifications }}</p>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-2.5 sm:p-4">
                                    <p class="text-xs sm:text-sm font-medium text-yellow-700">Pending</p>
                                    <p class="mt-1 text-xl sm:text-2xl lg:text-3xl font-semibold text-yellow-900">{{ $certificationStats['pending'] }}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-2.5 sm:p-4">
                                    <p class="text-xs sm:text-sm font-medium text-green-700">Verified</p>
                                    <p class="mt-1 text-xl sm:text-2xl lg:text-3xl font-semibold text-green-900">{{ $certificationStats['verified'] }}</p>
                                </div>
                                <div class="bg-red-50 rounded-lg p-2.5 sm:p-4">
                                    <p class="text-xs sm:text-sm font-medium text-red-700">Rejected</p>
                                    <p class="mt-1 text-xl sm:text-2xl lg:text-3xl font-semibold text-red-900">{{ $certificationStats['rejected'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificates Section with Search -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Search Header -->
                <div class="p-3 sm:p-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">Certificates</h3>
                        <div class="relative">
                            <input type="text" 
                                   id="certificateSearch" 
                                   placeholder="Search certificates..." 
                                   class="block w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile View -->
                <div class="block sm:hidden">
                    <div id="mobileCertificateList" class="divide-y divide-gray-200">
                        @foreach($getcertificates as $certificate)
                            <div class="p-3 certificate-item" 
                                 data-name="{{ strtolower($certificate->name) }}"
                                 data-organization="{{ strtolower($certificate->organization) }}">
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-start justify-between">
                                        <div class="truncate flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $certificate->name }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $certificate->organization }}</p>
                                        </div>
                                        <div class="ml-2 flex-shrink-0">
                                            @php
                                                $statusClasses = [
                                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                                    'Verified' => 'bg-green-100 text-green-800',
                                                    'Rejected' => 'bg-red-100 text-red-800'
                                                ][$certificate->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                                                {{ $certificate->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ asset('storage/' . $certificate->file) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Certificate
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate Name</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organization</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="desktopCertificateList" class="bg-white divide-y divide-gray-200">
                            @foreach($getcertificates as $certificate)
                                <tr class="hover:bg-gray-50 certificate-item"
                                    data-name="{{ strtolower($certificate->name) }}"
                                    data-organization="{{ strtolower($certificate->organization) }}">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $certificate->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $certificate->organization }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusClasses = [
                                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                                'Verified' => 'bg-green-100 text-green-800',
                                                'Rejected' => 'bg-red-100 text-red-800'
                                            ][$certificate->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                            {{ $certificate->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ asset('storage/' . $certificate->file) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="hidden p-8 text-center">
                    <p class="text-gray-500 text-sm">No certificates found matching your search.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Functionality Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('certificateSearch');
    const certificateItems = document.querySelectorAll('.certificate-item');
    const noResults = document.getElementById('noResults');
    let searchTimeout;

    function filterCertificates(searchTerm) {
        let hasResults = false;
        searchTerm = searchTerm.toLowerCase().trim();

        certificateItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const organization = item.getAttribute('data-organization');
            const matches = name.includes(searchTerm) || organization.includes(searchTerm);
            
            item.style.display = matches ? '' : 'none';
            if (matches) hasResults = true;
        });

        // Show/hide no results message
        noResults.style.display = hasResults ? 'none' : 'block';
        
        // Handle empty table state
        const mobileCertificateList = document.getElementById('mobileCertificateList');
        const desktopCertificateList = document.getElementById('desktopCertificateList');
        
        if (mobileCertificateList) {
            mobileCertificateList.style.display = hasResults ? '' : 'none';
        }
        if (desktopCertificateList) {
            desktopCertificateList.closest('table').style.display = hasResults ? '' : 'none';
        }
    }

    // Real-time search with debounce
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterCertificates(e.target.value);
        }, 300); // 300ms debounce
    });

    // Clear search when clicking the X button
    searchInput.addEventListener('search', (e) => {
        filterCertificates('');
    });

    // Initialize search if there's an initial value
    if (searchInput.value) {
        filterCertificates(searchInput.value);
    }
});
</script>
@endsection