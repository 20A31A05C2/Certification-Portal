@extends('layouts.adminsidebar')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Header -->
            <div class="glass-effect rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $organization }}</h1>
                        <p class="mt-2 text-gray-600">Certification Analysis Dashboard</p>
                    </div>
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                        <span class="font-semibold">Total Certificates:</span>
                        <span class="ml-2">{{ $certificates->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Certificates List -->
            @foreach ($certificates as $cert)
                <div class="glass-effect rounded-2xl shadow-lg p-6">
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('certification.details', ['organization' => $organization, 'certName' => $cert->name]) }}"
                                    class="group block">
                                    <h2
                                        class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $cert->name }}
                                    </h2>
                                    <p class="text-sm text-gray-500">Code: {{ $cert->code }}</p>
                                </a>
                            </div>
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                                <span class="font-semibold">Total Completions:</span>
                                <span class="ml-2">{{ $certificateStats[$cert->id]['total'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Batch Statistics -->
                        <div class="bg-white rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Batch Distribution</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Batch</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($certificateStats[$cert->id]['batches'] as $batch)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('certification.details', [
                                                        'organization' => $organization,
                                                        'certName' => $cert->name,
                                                        'batch' => $batch->batchyear,
                                                    ]) }}"
                                                        class="text-gray-900 hover:text-blue-600 transition-colors">
                                                        {{ $batch->batchyear ?: 'Not Specified' }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right">{{ $batch->count }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Branch Statistics -->
                        <div class="bg-white rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Branch Distribution</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Branch</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($certificateStats[$cert->id]['branches'] as $branch)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('certification.details', [
                                                        'organization' => $organization,
                                                        'certName' => $cert->name,
                                                        'branch' => $branch->branch,
                                                    ]) }}"
                                                        class="text-gray-900 hover:text-blue-600 transition-colors">
                                                        {{ $branch->branch ?: 'Not Specified' }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right">{{ $branch->count }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Specialization Statistics -->
                        <div class="bg-white rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Specialization Distribution</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Specialization</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($certificateStats[$cert->id]['specializations'] as $spec)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('certification.details', [
                                                        'organization' => $organization,
                                                        'certName' => $cert->name,
                                                        'specialization' => $spec->specialization,
                                                    ]) }}"
                                                        class="text-gray-900 hover:text-blue-600 transition-colors">
                                                        {{ $spec->specialization ?: 'Not Specified' }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right">{{ $spec->count }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
@endsection
