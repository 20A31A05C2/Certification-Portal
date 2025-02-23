@extends('layouts.sidebar')

@section('title', 'Available Internships')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="max-w-7xl mx-auto space-y-8 p-4 sm:p-6 lg:p-8">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div id="successAlert" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md relative transition-all duration-300 transform hover:scale-[1.02]" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <div>
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline ml-1">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="alert-dismiss absolute top-4 right-4 text-green-500 hover:text-green-700" data-alert-id="successAlert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="errorAlert" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md relative transition-all duration-300 transform hover:scale-[1.02]" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                <div>
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline ml-1">{{ session('error') }}</span>
                </div>
            </div>
            <button type="button" class="alert-dismiss absolute top-4 right-4 text-red-500 hover:text-red-700" data-alert-id="errorAlert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
        <form action="{{ route('userintern') }}" method="GET" id="searchForm">
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                <div class="w-full lg:w-2/3">
                    <div class="relative group">
                        <input type="text" 
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search internships..." 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-gray-600">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 group-hover:text-blue-500 transition-colors duration-300"></i>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-blue-50 px-6 py-3 rounded-xl">
                    <span class="text-sm font-medium text-blue-700">Applications</span>
                    <span class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold min-w-[2.5rem] text-center shadow-sm">
                        {{ $appliedInternships->count() }}
                    </span>
                </div>
            </div>
        </form>
    </div>

    <!-- Available Internships List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 p-6 bg-gradient-to-r from-blue-50 to-white">
            <h2 class="text-2xl font-bold text-gray-800">Available Internships</h2>
            <p class="text-gray-600 mt-2">Discover opportunities that align with your career goals</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($internships as $internship)
                <div class="p-6 hover:bg-gray-50 transition-all duration-300 group">
                    <div class="flex flex-col lg:flex-row justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-building text-blue-600 text-2xl"></i>
                                </div>
                                <div class="space-y-3 flex-1">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $internship->name }}</h3>
                                        <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-600">
                                            <span class="font-semibold px-3 py-1 bg-gray-100 rounded-full">{{ $internship->organization }}</span>
                                            <span class="flex items-center gap-2">
                                                <i class="fas fa-clock text-blue-500"></i>
                                                Posted {{ $internship->created_at->format('M d, Y') }}
                                            </span>
                                            <span class="flex items-center gap-2">
                                                <i class="fas fa-calendar-alt text-blue-500"></i>
                                                Ends {{ $internship->end_date ? \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') : 'No end date' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-base leading-relaxed">{{ $internship->description }}</p>
                                    @if($internship->link)
                                        <div class="pt-2">
                                            <a href="{{ $internship->link }}" 
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium group">
                                                <span>View Details</span>
                                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('apply.internship', $internship->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Apply Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 mb-6 animate-pulse">
                        <i class="fas fa-search text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">No internships found</h3>
                    <p class="text-gray-600 max-w-md mx-auto">We couldn't find any internships matching your search. Try different keywords or check back later!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Applied Internships Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 p-6 bg-gradient-to-r from-green-50 to-white">
            <h2 class="text-2xl font-bold text-gray-800">Applied Internships</h2>
            <p class="text-gray-600 mt-2">Monitor your application progress</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($appliedInternships as $applied)
                <div class="p-6 bg-gray-50 hover:bg-white transition-all duration-300">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="space-y-3 flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $applied->name }}</h3>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    {{ ucfirst($applied->status) }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                <span class="font-semibold px-3 py-1 bg-gray-100 rounded-full">{{ $applied->organization }}</span>
                                <span class="flex items-center gap-2 text-green-600">
                                    <i class="fas fa-clock"></i>
                                    Applied on {{ $applied->created_at->format('M d, Y') }}
                                </span>
                                <span class="flex items-center gap-2 text-green-600">
                                    <i class="fas fa-calendar-alt"></i>
                                    Ends {{ $applied->end_date ? \Carbon\Carbon::parse($applied->end_date)->format('M d, Y') : 'No end date' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-base leading-relaxed">{{ $applied->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-6">
                        <i class="fas fa-clipboard-list text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">No applications yet</h3>
                    <p class="text-gray-600 max-w-md mx-auto">Ready to start your journey? Browse and apply for internships above!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced alert dismissal with animation
        function dismissAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Alert dismissal handlers
        document.querySelectorAll('.alert-dismiss').forEach(button => {
            button.addEventListener('click', function() {
                const alertId = this.getAttribute('data-alert-id');
                dismissAlert(alertId);
            });
        });

        // Auto-dismiss alerts with progressive delay
        ['successAlert', 'errorAlert'].forEach((alertId, index) => {
            const alert = document.getElementById(alertId);
            if (alert) {
                setTimeout(() => {
                    dismissAlert(alertId);
                }, 3000 + (index * 500));
            }
        });

        // Debounced search with loading state
        const searchInput = document.getElementById('search');
        const searchForm = document.getElementById('searchForm');
        let searchTimeout;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                const searchIcon = this.parentElement.querySelector('.fas.fa-search');
                
                // Add loading state
                if (searchIcon) {
                    searchIcon.classList.add('animate-spin');
                }

                searchTimeout = setTimeout(() => {
                    searchForm.submit();
                }, 500);
            });
        }
    });
</script>

@endsection