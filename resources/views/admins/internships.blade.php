@extends('layouts.adminsidebar')

@section('title', 'Internships Management')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gray-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div id="successAlert" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl shadow-md relative transform transition-all duration-300" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <div>
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline ml-1">{{ session('success') }}</span>
                        </div>
                    </div>
                    <button onclick="dismissAlert('successAlert')" class="absolute top-4 right-4 text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="errorAlert" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-md relative transform transition-all duration-300" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline ml-1">{{ session('error') }}</span>
                        </div>
                    </div>
                    <button onclick="dismissAlert('errorAlert')" class="absolute top-4 right-4 text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-briefcase text-2xl text-indigo-600"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Internships Management</h1>
                            <p class="text-gray-600 mt-1">Manage and track internship opportunities</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-indigo-50 px-6 py-3 rounded-xl">
                        <i class="fas fa-chart-bar text-indigo-600"></i>
                        <div>
                            <span class="text-sm font-medium text-indigo-600">Total Internships</span>
                            <span class="block text-2xl font-bold text-indigo-700">{{ $totalInternships }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Internship Form -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-xl text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Add New Internship</h2>
                        <p class="text-gray-600 mt-1">Create a new internship opportunity</p>
                    </div>
                </div>
                
                <form action="{{ route('internships.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-tag text-gray-400"></i>
                                    Internship Name
                                </label>
                                <input type="text" name="name" 
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors @error('name') border-red-300 @enderror"
                                    placeholder="e.g. Software Development Intern">
                                @error('name')
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-building text-gray-400"></i>
                                    Organization
                                </label>
                                <input type="text" name="organization" 
                                    value="{{ old('organization') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors @error('organization') border-red-300 @enderror"
                                    placeholder="e.g. Tech Solutions Inc.">
                                @error('organization')
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-link text-gray-400"></i>
                                    Application Link
                                </label>
                                <input type="url" name="link" 
                                    value="{{ old('link') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors @error('link') border-red-300 @enderror"
                                    placeholder="https://example.com/apply">
                                @error('link')
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                    End Date
                                </label>
                                <input type="date" name="end_date" 
                                    value="{{ old('end_date') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors @error('end_date') border-red-300 @enderror">
                                @error('end_date')
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                    Description
                                </label>
                                <textarea name="description" rows="8"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors resize-none @error('description') border-red-300 @enderror"
                                    placeholder="Enter detailed internship description, requirements, and responsibilities...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add Internship
                        </button>
                    </div>
                </form>
            </div>

            <!-- Current Internships Section -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list text-xl text-indigo-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Current Internships</h2>
                            <p class="text-gray-600 mt-1">Manage existing internship listings</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($internships->isEmpty())
                        <div class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
                                <i class="fas fa-briefcase text-2xl text-indigo-600"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">No internships available</h3>
                            <p class="text-gray-600 max-w-sm mx-auto">
                                Get started by adding your first internship opportunity using the form above.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Organization</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">End Date</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Link</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($internships as $internship)
                                        <tr class="hover:bg-gray-50 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-gray-900">{{ $internship->name }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-600">{{ $internship->organization }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($internship->end_date)
                                                    <span class="inline-flex items-center gap-2 text-sm text-gray-600">
                                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                                        {{ \Carbon\Carbon::parse($internship->end_date)->format('M d, Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-gray-400">Not specified</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($internship->link)
                                                    <a href="{{ $internship->link }}" 
                                                       target="_blank" 
                                                       class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                                                        <span>Visit Link</span>
                                                        <i class="fas fa-external-link-alt ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                                    </a>
                                                @else
                                                    <span class="text-sm text-gray-400">No link provided</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-3">
                                                    <button class="p-2 text-indigo-600 hover:text-indigo-800 transition-colors">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="p-2 text-red-600 hover:text-red-800 transition-colors"
                                                            onclick="return confirm('Are you sure you want to delete this internship? This action cannot be undone.')"
                                                        >
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
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

    // Auto-dismiss alerts with progressive delay
    ['successAlert', 'errorAlert'].forEach((alertId, index) => {
        const alert = document.getElementById(alertId);
        if (alert) {
            setTimeout(() => {
                dismissAlert(alertId);
            }, 5000 + (index * 500)); // Progressive delay for multiple alerts
        }
    });

    // Form validation enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-300');
                    
                    // Add shake animation to invalid fields
                    field.classList.add('animate-shake');
                    setTimeout(() => {
                        field.classList.remove('animate-shake');
                    }, 500);
                } else {
                    field.classList.remove('border-red-300');
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Real-time validation feedback
        form.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('border-red-300');
                } else {
                    this.classList.remove('border-red-300');
                }
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('border-red-300')) {
                    this.classList.remove('border-red-300');
                }
            });
        });
    }

    // Add smooth hover effects to table rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('transform', 'scale-[1.01]', 'shadow-sm');
        });
        
        row.addEventListener('mouseleave', () => {
            row.classList.remove('transform', 'scale-[1.01]', 'shadow-sm');
        });
    });

    // Enhanced delete confirmation with loading state
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this internship? This action cannot be undone.')) {
                // Add loading state to button
                const button = this.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                // Submit the form
                this.submit();
            }
        });
    });
});
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}

.animate-shake {
    animation: shake 0.3s ease-in-out;
}
</style>

@endsection