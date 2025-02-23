@extends('layouts.adminsidebar')

@section('title', 'Add Team Member')

@php
use App\Models\Certification;
use App\Models\User;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 p-3 sm:p-5 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Team Management</h1>
            <p class="text-gray-600 mt-1">Add and manage verification team members</p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
            <!-- Add Member Form -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-plus text-lg text-indigo-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Add New Member</h2>
                                <p class="text-sm text-gray-500">Enter member details below</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('team.store') }}" method="POST" class="p-5 space-y-5">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="username" required 
                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow text-sm"
                                    placeholder="Enter username"
                                    value="{{ old('username') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" required 
                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow text-sm"
                                    placeholder="Enter email address"
                                    value="{{ old('email') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" required 
                                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow text-sm"
                                        placeholder="Create password">
                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye toggle-password"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Certifications
                                </label>
                                <select id="certifications-select" name="certifications[]" multiple class="w-full select2-input">
                                    @if(old('certifications'))
                                        @foreach(Certification::whereIn('id', old('certifications'))->get() as $cert)
                                            <option value="{{ $cert->id }}" selected>{{ $cert->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Assigned Users
                                </label>
                                <select id="users-select" name="assigned_users[]" multiple class="w-full select2-input">
                                    @if(old('assigned_users'))
                                        @foreach(User::whereIn('id', old('assigned_users'))->get() as $user)
                                            <option value="{{ $user->id }}" selected>{{ $user->username }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                class="w-full px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-colors text-sm font-medium">
                                Create Member Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Members List -->
            <div class="xl:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-lg text-green-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Current Members</h2>
                                <p class="text-sm text-gray-500">Manage existing team members</p>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                    @forelse($members as $member)
<div class="p-4 sm:p-5 hover:bg-gray-50/50 transition-colors">
    <div class="flex items-center justify-between gap-4">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-indigo-600">
                        {{ strtoupper(substr($member->username, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 truncate">{{ $member->username }}</h3>
                    <p class="text-sm text-gray-500 truncate">{{ $member->email }}</p>
                    
                    @if(!empty($member->certifications))
                    <div class="mt-1 flex flex-wrap gap-1">
                        @foreach(Certification::whereIn('id', $member->certifications)->get() as $cert)
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">
                            {{ $cert->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    
                    @if(!empty($member->assigned_users))
                    <div class="mt-1 flex flex-wrap gap-1">
                        @foreach(User::whereIn('id', $member->assigned_users)->get() as $user)
                        <span class="text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded">
                            {{ $user->userid }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
    <a href="{{ route('team.edit', $member->id) }}" 
        class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
        <i class="fas fa-edit"></i>
    </a>
        <div class="flex items-center gap-2">
        <form action="{{ route('teamdelete', $member->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" 
        onclick="return confirm('Are you sure you want to delete this member?')"
        class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors">
        <i class="fas fa-trash"></i>
    </button>
</form>
        </div>
    </div>
</div>

                        @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-gray-500 font-medium">No members yet</h3>
                            <p class="text-sm text-gray-400 mt-1">Add your first member using the form</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        padding: 0.5rem;
        min-height: 42px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #6366F1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #EEF2FF;
        border: none;
        color: #4F46E5;
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
        margin: 0.125rem;
        font-size: 0.875rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #4F46E5;
        margin-right: 0.375rem;
        border: none;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background: none;
        color: #312E81;
    }
    .select2-dropdown {
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #EEF2FF;
        color: #4F46E5;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 dropdowns
    $('#certifications-select, #users-select').select2({
    placeholder: "Search and select...",
    allowClear: true,
    ajax: {
        url: function() {
            return $(this).attr('id') === 'certifications-select'
                ? '{{ route("certifications.search") }}'
                : '{{ route("users.search") }}';
        },
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                search: params.term, // search term
                page: params.page || 1
            };
        },
        processResults: function(data) {
            return {
                results: data.map(item => ({
                    id: item.id,
                    text: item.name || item.userid
                }))
            };
        },
        cache: true
    },
    minimumInputLength: 1
});


    // Password visibility toggle
    $('.toggle-password').on('click', function() {
        const input = $(this).closest('div').find('input');
        const icon = $(this);
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>

@endsection