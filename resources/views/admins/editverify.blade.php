@extends('layouts.adminsidebar')
@section('title', 'Edit Team Member')

@php
use App\Models\Certification;
use App\Models\User;
@endphp

@section('content')
<div class="min-h-screen p-4 lg:p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Edit Team Member</h1>
            <p class="text-sm text-gray-600 mt-1">Update member information and access permissions</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-md border border-red-200">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow border border-gray-100">
            <form action="{{ route('team.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6">
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="text-base font-medium text-gray-800 mb-4">Basic Information</h2>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm text-gray-700">Username</label>
                                <input type="text" 
                                    name="username" 
                                    required 
                                    value="{{ old('username', $member->username) }}"
                                    class="mt-1 w-full px-3 py-2 bg-white border border-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700">Email Address</label>
                                <input type="email" 
                                    name="email" 
                                    required 
                                    value="{{ old('email', $member->email) }}"
                                    class="mt-1 w-full px-3 py-2 bg-white border border-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm text-gray-700">
                                    Password
                                    <span class="text-gray-400 text-xs ml-1">(Leave blank to keep current)</span>
                                </label>
                                <div class="relative mt-1">
                                    <input type="password" 
                                        name="password"
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10">
                                    <button type="button" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye toggle-password"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions & Access -->
                    <div>
   <h2 class="text-base font-medium text-gray-800 mb-4">Permissions & Access</h2>
   <div class="grid gap-6 md:grid-cols-2">
       <div class="relative">
           <label class="block text-sm text-gray-700 mb-2">Certifications</label>
           <div class="rounded-lg bg-white shadow-sm border border-gray-200 group hover:border-blue-400 transition-colors duration-150">
               <select id="certifications-select" name="certifications[]" multiple class="select2-input">
                   @if(old('certifications'))
                       @foreach(Certification::whereIn('id', old('certifications'))->get() as $cert)
                           <option value="{{ $cert->id }}" selected>{{ $cert->name }}</option>
                       @endforeach
                   @endif
               </select>
           </div>
       </div>

       <div class="relative">
           <label class="block text-sm text-gray-700 mb-2">Assigned Users</label>
           <div class="rounded-lg bg-white shadow-sm border border-gray-200 group hover:border-blue-400 transition-colors duration-150">
               <select id="users-select" name="assigned_users[]" multiple class="select2-input">
                   @if(old('assigned_users'))
                       @foreach(User::whereIn('id', old('assigned_users'))->get() as $user)
                           <option value="{{ $user->id }}" selected>{{ $user->username }}</option>
                       @endforeach
                   @endif
               </select>
           </div>
       </div>
   </div>
</div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('team.index') }}" 
                        class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
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
    // Select2 Configuration
    $('.select2-input').select2({
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
                    search: params.term,
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

    // Password Toggle
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