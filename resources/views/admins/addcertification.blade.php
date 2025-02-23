@extends('layouts.adminsidebar')

@section('title', 'Certification Management')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="min-h-screen bg-gray-50/30">
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Responsive Container with max-width -->
            <div class="max-w-7xl mx-auto">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm relative"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline ml-2">{{ session('success') }}</span>
                        <button class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                            <span class="text-green-500">×</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm relative"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline ml-2">{{ session('error') }}</span>
                        <button class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                            <span class="text-red-500">×</span>
                        </button>
                    </div>
                @endif

                <!-- Page Header - Responsive Layout -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-2 sm:mb-0">Certification Management</h1>
                        <span class="inline-flex px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            Total Certifications: {{ $totalCertifications }}
                        </span>
                    </div>
                </div>

                <!-- Add New Certification Box - Responsive Grid -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Certification</h2>
                    <form action="{{ route('addcertify.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Certification Name</label>
                                <input type="text" name="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    value="{{ old('name') }}" placeholder="e.g. AWS Certified Cloud Practitioner">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Certification Code</label>
                                <input type="text" name="code"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror"
                                    value="{{ old('code') }}" placeholder="e.g. CLF-C02">
                                @error('code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Organization</label>
                                <input type="text" name="organization"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('organization') border-red-500 @enderror"
                                    value="{{ old('organization') }}" placeholder="e.g. Amazon">
                                @error('code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Add Certification
                            </button>

                            <a href="{{ route('certifications.upload') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                <i class="fas fa-upload mr-2"></i>
                                Upload Document
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Current Certifications Section - Responsive Table -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Current Certifications</h2>
                    </div>

                    <div class="p-4 sm:p-6">
                        @if ($certifications->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No certifications</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by adding a new certification.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Certificate Details
                                            </th>
                                            <th scope="col" class="relative px-4 sm:px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($certifications as $certification)
                                            <tr class="hover:bg-gray-50" id="certification-row-{{ $certification->id }}">
                                                <td class="px-4 sm:px-6 py-4">
                                                    <!-- View Mode -->
                                                    <div class="flex items-center view-mode-{{ $certification->id }}">
                                                        <div
                                                            class="hidden sm:flex flex-shrink-0 h-10 w-10 items-center justify-center bg-blue-100 rounded-lg">
                                                            <svg class="h-6 w-6 text-blue-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m-4 4h-4m4 4l4-4m-4 4v-4m4 4h-4" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-0 sm:ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $certification->name }}</div>
                                                            <div class="text-sm text-gray-500">Code:
                                                                {{ $certification->code }}</div>
                                                            <div class="text-sm text-gray-500">Organization:
                                                                {{ $certification->organization }}</div>
                                                        </div>
                                                    </div>

                                                    <!-- Edit Mode -->
                                                    <div class="edit-mode-{{ $certification->id }} hidden space-y-3">
                                                        <form id="edit-form-{{ $certification->id }}"
                                                            action="{{ route('update.certify', $certification->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="space-y-3">
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700">Name</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ $certification->name }}"
                                                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700">Code</label>
                                                                    <input type="text" name="code"
                                                                        value="{{ $certification->code }}"
                                                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700">Organization</label>
                                                                    <input type="text" name="organization"
                                                                        value="{{ $certification->organization }}"
                                                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-4">
                                                    <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                                                        <!-- View Mode Buttons -->
                                                        <div
                                                            class="view-mode-{{ $certification->id }} flex justify-end gap-2">
                                                            <button onclick="toggleEdit({{ $certification->id }})"
                                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                <svg class="h-4 w-4 mr-1.5 text-gray-500" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                <span class="hidden sm:inline">Edit</span>
                                                            </button>

                                                            <form
                                                                action="{{ route('delete.certify', $certification->id) }}"
                                                                method="POST" class="inline-block"
                                                                onsubmit="return confirm('Are you sure?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                    <svg class="h-4 w-4 mr-1.5 text-red-500"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                    <span class="hidden sm:inline">Delete</span>
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <!-- Edit Mode Buttons -->
                                                        <div
                                                            class="edit-mode-{{ $certification->id }} hidden flex justify-end gap-2">
                                                            <button onclick="saveChanges({{ $certification->id }})"
                                                                class="inline-flex items-center px-3 py-1.5 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                                <svg class="h-4 w-4 mr-1.5 text-green-500" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Save
                                                            </button>
                                                            <button onclick="cancelEdit({{ $certification->id }})"
                                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                <svg class="h-4 w-4 mr-1.5 text-gray-500" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Cancel
                                                            </button>
                                                        </div>
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

    <!-- JavaScript for handling inline editing with improved mobile support -->
    <script>
        function toggleEdit(id) {
            // Add smooth transition classes
            const viewElements = document.querySelectorAll(`.view-mode-${id}`);
            const editElements = document.querySelectorAll(`.edit-mode-${id}`);

            // Hide view mode with fade
            viewElements.forEach(el => {
                el.classList.add('opacity-0');
                setTimeout(() => {
                    el.classList.add('hidden');
                    // Show edit mode with fade in
                    editElements.forEach(editEl => {
                        editEl.classList.remove('hidden');
                        setTimeout(() => {
                            editEl.classList.remove('opacity-0');
                        }, 50);
                    });
                }, 200);
            });
        }

        function cancelEdit(id) {
            const viewElements = document.querySelectorAll(`.view-mode-${id}`);
            const editElements = document.querySelectorAll(`.edit-mode-${id}`);

            // Hide edit mode with fade
            editElements.forEach(el => {
                el.classList.add('opacity-0');
                setTimeout(() => {
                    el.classList.add('hidden');
                    // Show view mode with fade in
                    viewElements.forEach(viewEl => {
                        viewEl.classList.remove('hidden');
                        setTimeout(() => {
                            viewEl.classList.remove('opacity-0');
                        }, 50);
                    });
                }, 200);
            });

            // Reset form
            document.getElementById(`edit-form-${id}`).reset();
        }

        function saveChanges(id) {
            const form = document.getElementById(`edit-form-${id}`);
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');

            // Disable submit button and show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Saving...
        `;
            }

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update UI with smooth transition
                    const row = document.querySelector(`#certification-row-${id}`);
                    const nameElement = row.querySelector('.text-gray-900');
                    const codeElement = row.querySelector('.text-gray-500:nth-child(2)');
                    const organizationElement = row.querySelector('.text-gray-500:nth-child(3)');

                    // Fade out current content
                    nameElement.style.opacity = '0';
                    codeElement.style.opacity = '0';
                    organizationElement.style.opacity = '0';

                    setTimeout(() => {
                        // Update content
                        nameElement.textContent = formData.get('name');
                        codeElement.textContent = `Code: ${formData.get('code')}`;
                        organizationElement.textContent = `Organization: ${formData.get('organization')}`;

                        // Fade in new content
                        nameElement.style.opacity = '1';
                        codeElement.style.opacity = '1';
                        organizationElement.style.opacity = '1';

                        // Exit edit mode
                        cancelEdit(id);

                        // Show success message
                        showMessage('success', 'Certification updated successfully!');
                    }, 200);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Failed to update certification. Please try again.');
                })
                .finally(() => {
                    // Re-enable submit button
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = `
                <svg class="h-4 w-4 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save
            `;
                    }
                });
        }

        function showMessage(type, message) {
            // Remove any existing messages
            const existingMessages = document.querySelectorAll('.alert-message');
            existingMessages.forEach(msg => {
                msg.classList.add('opacity-0');
                setTimeout(() => msg.remove(), 300);
            });

            // Create new message element
            const alertDiv = document.createElement('div');
            alertDiv.className = `mb-4 p-4 rounded-lg shadow-sm relative alert-message opacity-0 transition-opacity duration-300 ${
        type === 'success'
            ? 'bg-green-100 border border-green-400 text-green-700'
            : 'bg-red-100 border border-red-400 text-red-700'
    }`;

            alertDiv.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${type === 'success'
                    ? `<svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                       </svg>`
                    : `<svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                       </svg>`
                }
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
                        onclick="this.closest('.alert-message').remove()">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    `;

            // Insert the message at the top of the container
            const container = document.querySelector('.max-w-7xl');
            container.insertBefore(alertDiv, container.firstChild);

            // Trigger fade in
            setTimeout(() => alertDiv.classList.remove('opacity-0'), 50);

            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.classList.add('opacity-0');
                setTimeout(() => alertDiv.remove(), 300);
            }, 5000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure CSRF token is present in all forms
            const token = document.querySelector('meta[name="csrf-token"]').content;
            document.querySelectorAll('form').forEach(form => {
                if (!form.querySelector('input[name="_token"]')) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = token;
                    form.appendChild(csrfInput);
                }
            });

            // Add transition classes
            document.querySelectorAll('.view-mode, .edit-mode').forEach(el => {
                el.classList.add('transition-opacity', 'duration-200', 'ease-in-out');
            });
        });
    </script>
@endsection
