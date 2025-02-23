@extends('layouts.teamsidebar')

@section('title', 'Verify Certificates')

@section('content')
<!-- Success Message -->
@if(session('success'))
<div class="fixed bottom-4 right-4 z-50 bg-green-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg" 
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
</div>
@endif

<!-- Error Message -->
@if(session('error'))
<div class="fixed bottom-4 right-4 z-50 bg-red-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg"
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)">
    {{ session('error') }}
</div>
@endif

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
    <!-- Header and Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Certification Submissions</h2>
        
        <!-- Search and Filter Form -->
        <form action="{{ route('verify.certify') }}" method="GET" class="w-full sm:w-auto flex flex-col sm:flex-row gap-3 sm:gap-4">
            <select name="status" 
                    onchange="this.form.submit()" 
                    class="w-full sm:w-auto rounded-lg border-gray-300 text-sm">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Submissions</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending Only</option>
                <option value="Verified" {{ request('status') == 'Verified' ? 'selected' : '' }}>Verified Only</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected Only</option>
            </select>
            <div class="relative flex-1 sm:flex-none">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search User ID..." 
                       class="w-full rounded-lg border-gray-300 text-sm pr-8">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-400"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request('search'))
    <div class="mb-4 text-sm text-gray-600">
        Found {{ $usercertifications->total() }} result(s) for "{{ request('search') }}"
    </div>
    @endif

    <!-- Responsive Table -->
    <div class="overflow-x-auto -mx-4 sm:mx-0">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden border border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate Name</th>
                            <th class="hidden sm:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submission Date</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($usercertifications as $certification)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $certification->userid }}</div>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $certification->name }}</div>
                                <!-- Mobile-only date -->
                                <div class="sm:hidden text-xs text-gray-500 mt-1">
                                    {{ $certification->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="hidden sm:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $certification->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($certification->status == 'Pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($certification->status == 'Verified')
                                        bg-green-100 text-green-800
                                    @elseif($certification->status == 'Rejected')
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ $certification->status }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-2">
                                    <button onclick="viewCertification({{ $certification->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        View
                                    </button>

                                    @if($certification->status == 'Pending')
                                        <form action="{{ route('user.verify', $certification->id) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900">
                                                Verify
                                            </button>
                                        </form>

                                        <form action="{{ route('user.reject', $certification->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to reject this certification?')">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900">
                                                Reject
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 sm:px-6 py-4 text-center text-gray-500">
                                @if(request('search'))
                                    No certifications found matching your search criteria
                                @else
                                    No certifications submitted yet
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($usercertifications->count() > 0)
    <div class="mt-4 sm:mt-6">
        {{ $usercertifications->links() }}
    </div>
@endif
</div>

<script>
function viewCertification(id) {
    const loadingToast = document.createElement('div');
    loadingToast.className = 'fixed bottom-4 right-4 z-50 bg-blue-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg';
    loadingToast.innerHTML = 'Loading certificate...';
    document.body.appendChild(loadingToast);

    // Open in new window
    window.open(`/team/certification/${id}`, '_blank');
    
    setTimeout(() => {
        loadingToast.remove();
    }, 1000);
}

function showToast(message, color = 'blue') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 z-50 bg-${color}-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg`;
    toast.innerHTML = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

window.onerror = function(msg, url, lineNo, columnNo, error) {
    showToast('Error: ' + (error?.message || msg), 'red');
    return false;
};
</script>
@endsection