@extends('layouts.adminsidebar')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
        <div class="max-w-8xl mx-auto space-y-8">
            <!-- Header -->
            <div class="glass-effect rounded-2xl shadow-lg p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">{{ $certName }}</h1>
                        <p class="mt-3 text-lg text-gray-600">{{ $organization }} - Certificate Details</p>
                    </div>
                    <a href="{{ route('viewmore', $organization) }}"
                        class="inline-flex items-center bg-blue-100 text-blue-800 px-6 py-3 rounded-lg hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Overview
                    </a>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if (request('batch') || request('branch') || request('specialization'))
                <div class="glass-effect rounded-2xl shadow-lg p-6">
                    <div class="flex flex-wrap gap-3">
                        @if (request('batch'))
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Batch: {{ request('batch') }}
                                <a href="{{ route('certification.details', [
                                    'organization' => $organization,
                                    'certName' => $certName,
                                    'branch' => request('branch'),
                                    'specialization' => request('specialization'),
                                ]) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                            </span>
                        @endif

                        @if (request('branch'))
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Branch: {{ request('branch') }}
                                <a href="{{ route('certification.details', [
                                    'organization' => $organization,
                                    'certName' => $certName,
                                    'batch' => request('batch'),
                                    'specialization' => request('specialization'),
                                ]) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                            </span>
                        @endif

                        @if (request('specialization'))
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Specialization: {{ request('specialization') }}
                                <a href="{{ route('certification.details', [
                                    'organization' => $organization,
                                    'certName' => $certName,
                                    'batch' => request('batch'),
                                    'branch' => request('branch'),
                                ]) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                            </span>
                        @endif

                        <a href="{{ route('certification.details', ['organization' => $organization, 'certName' => $certName]) }}"
                            class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear all filters
                        </a>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div class="glass-effect rounded-2xl shadow-lg p-8">
                <form
                    action="{{ route('certification.details', ['organization' => $organization, 'certName' => $certName]) }}"
                    method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Batch Filter -->
                    <div class="space-y-2">
                        <label for="batch" class="block text-sm font-medium text-gray-700">Batch Year</label>
                        <select name="batch" id="batch"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-11"
                            onchange="this.form.submit()">
                            <option value="">All Batches</option>
                            @foreach ($filterOptions['batches'] as $batch)
                                <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>
                                    {{ $batch }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Branch Filter -->
                    <div class="space-y-2">
                        <label for="branch" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch" id="branch"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-11"
                            onchange="this.form.submit()">
                            <option value="">All Branches</option>
                            @foreach ($filterOptions['branches'] as $branch)
                                <option value="{{ $branch }}" {{ request('branch') == $branch ? 'selected' : '' }}>
                                    {{ $branch }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Specialization Filter -->
                    <div class="space-y-2">
                        <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                        <select name="specialization" id="specialization"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-11"
                            onchange="this.form.submit()">
                            <option value="">All Specializations</option>
                            @foreach ($filterOptions['specializations'] as $spec)
                                <option value="{{ $spec }}"
                                    {{ request('specialization') == $spec ? 'selected' : '' }}>
                                    {{ $spec }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="flex items-end">
                        <a href="{{ route('certification.details', ['organization' => $organization, 'certName' => $certName]) }}"
                            class="w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors text-center h-11 flex items-center justify-center">
                            Reset Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="glass-effect rounded-2xl shadow-lg p-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User ID</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Batch</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Branch</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Specialization</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Completed On</th>
                                <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Certificate</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->userid }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->username }}
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->batchyear }}
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->branch }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->specialization }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $user->status === 'verified'
                                                ? 'bg-green-100 text-green-800'
                                                : ($user->status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if (is_string($user->file))
                                            <a href="{{ asset('storage/' . $user->file) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Certificate
                                            </a>
                                        @else
                                            <span class="text-gray-500">No file available</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-8 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <p class="text-lg font-medium">No certificates found matching the selected
                                                criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->count() > 0)
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterSelects = document.querySelectorAll(
                    'select[name="batch"], select[name="branch"], select[name="specialization"]');
                filterSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        this.closest('form').submit();
                    });
                });
            });
        </script>
    @endpush
@endsection
