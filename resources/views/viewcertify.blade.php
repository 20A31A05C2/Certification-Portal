@extends('layouts.sidebar')

@section('title', 'ViewCertify')

@section('content')
<div class="w-full p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">My Certifications</h1>
            <a href="{{ route('addcertify') }}" 
               class="inline-flex w-full sm:w-auto justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add New
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-4 bg-green-50 p-3 sm:p-4 rounded-lg text-green-800 text-sm sm:text-base">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-50 p-3 sm:p-4 rounded-lg text-red-800 text-sm sm:text-base">
        {{ session('error') }}
    </div>
    @endif

    <!-- Search Section -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
        <div class="col-span-full md:col-span-2">
            <form action="{{ route('viewcertify') }}" method="GET" class="relative" id="searchForm">
                <input type="text" 
                       name="search"
                       id="searchInput"
                       value="{{ request('search') }}"
                       placeholder="Search certifications..." 
                       class="w-full pl-10 pr-4 py-2 text-sm sm:text-base border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </form>
        </div>
        @if(request('search'))
        <div class="col-span-full md:col-span-1">
            <a href="{{ route('viewcertify') }}" 
               class="inline-flex w-full md:w-auto justify-center items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Clear Search
            </a>
        </div>
        @endif
    </div>

    <!-- Results Count -->
    @if(request('search'))
    <div class="mb-4 text-sm text-gray-600">
        Found {{ $certifications->total() }} result(s) for "{{ request('search') }}"
    </div>
    @endif

    <!-- Certifications Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        @forelse($certifications as $certification)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $certification->name }}</h3>
                        </div>
                        <div class="flex items-center mt-2">
                            <span class="text-sm font-medium mr-2">Status:</span>
                            <span class="px-2.5 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium
                                {{ $certification->status == 'Pending' ? 'bg-yellow-500 text-white' : '' }}
                                {{ $certification->status == 'Approved' ? 'bg-green-500 text-white' : '' }}
                                {{ $certification->status == 'Rejected' ? 'bg-red-500 text-white' : '' }}
                                {{ $certification->status == 'Verified' ? 'bg-blue-500 text-white' : '' }}
                                {{ !in_array($certification->status, ['Pending', 'Approved', 'Rejected', 'Verified']) ? 'bg-gray-500 text-white' : '' }}">
                                {{ $certification->status }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Added on: {{ $certification->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Certificate Actions -->
                <div class="mt-4">
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            @if($certification->status == 'Verified')
                                <a href="{{ route('download.certificate', $certification->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                    </svg>
                                    Download
                                </a>
                            @else
                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                    <a href="{{ route('download.certificate', $certification->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                        </svg>
                                        Download
                                    </a>
                                    <button onclick="openEditModal({{ $certification->id }}, '{{ $certification->name }}', '{{ $certification->status }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('deleteview.certify', $certification->id) }}" 
                                          method="POST" 
                                          class="inline" 
                                          onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-red-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-1 lg:col-span-2 text-center py-8 sm:py-12">
            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No certifications found</h3>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                @if(request('search'))
                    No results found for "{{ request('search') }}". Try a different search term or clear the search.
                @else
                    Get started by adding your first certification.
                @endif
            </p>
            <div class="mt-4 sm:mt-6">
                <a href="{{ route('addcertify') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Certification
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($certifications->hasPages())
    <div class="mt-6 sm:mt-8">
        {{ $certifications->links() }}
    </div>
    @endif

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Edit Certification</h3>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="edit_name" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   required>
                        </div>
                        <div>
                            <label for="edit_file" class="block text-sm font-medium text-gray-700">Update Certificate (Optional)</label>
                            <input type="file" 
                                name="file" 
                                id="edit_file" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                        <button type="button" 
                                onclick="closeEditModal()" 
                                class="w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let searchTimeout;

    // Real-time search with debouncing
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            searchForm.submit();
        }, 500);
    });

    // Clear search timeout if user submits form manually
    searchForm.addEventListener('submit', function() {
        clearTimeout(searchTimeout);
    });

    // Handle mobile responsiveness for modal
    function adjustModalPosition() {
        const modal = document.getElementById('editModal');
        const modalContent = modal.querySelector('.relative');
        
        if (window.innerWidth < 640) { // sm breakpoint
            modalContent.style.top = '10px';
            modalContent.style.margin = '10px';
        } else {
            modalContent.style.top = '20px';
            modalContent.style.margin = 'auto';
        }
    }

    window.addEventListener('resize', adjustModalPosition);
    adjustModalPosition(); // Initial call
});

// Delete confirmation with responsive dialog
function confirmDelete(event) {
    event.preventDefault();
    
    // Use a more modern confirmation dialog if available
    if (window.confirm('Are you sure you want to delete this certification?')) {
        event.target.submit();
    }
    return false;
}

// Enhanced modal functions with responsive handling
function openEditModal(id, name, status) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const nameInput = document.getElementById('edit_name');


    // Set form action URL
    form.action = `/certifications/${id}`;

    // Set current values
    nameInput.value = name;

    // Show modal with transition
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling

    // Focus on first input for better accessibility
    setTimeout(() => {
        nameInput.focus();
    }, 100);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    
    // Hide modal with transition
    modal.classList.add('hidden');
    document.body.style.overflow = ''; // Restore scrolling

    // Reset form
    const form = document.getElementById('editForm');
    form.reset();
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Handle escape key for modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Add touch events for mobile devices
let touchStartY = 0;
const modalContent = document.querySelector('#editModal .relative');

modalContent.addEventListener('touchstart', function(e) {
    touchStartY = e.touches[0].clientY;
}, { passive: true });

modalContent.addEventListener('touchmove', function(e) {
    const touchY = e.touches[0].clientY;
    const diff = touchStartY - touchY;

    // If user swipes down and modal is scrolled to top, close it
    if (diff < -50 && this.scrollTop === 0) {
        closeEditModal();
    }
}, { passive: true });
</script>
@endsection