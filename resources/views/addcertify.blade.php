@extends('layouts.sidebar')

@section('title', 'AddCertify')

@section('content')
    <!-- Main container with responsive padding and width -->
    <div class="w-full p-4 sm:p-6 lg:p-8">
        <!-- Content wrapper with max-width and auto margins -->
        <div class="max-w-4xl mx-auto lg:max-w-5xl xl:max-w-6xl">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gray-50 p-4 sm:p-6 border-b border-gray-100">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                        <h3 class="text-lg sm:text-xl text-gray-800 font-semibold">Add Your Certification</h3>
                        <span
                            class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">Verify
                            & Add</span>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="p-4 sm:p-6">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-50 p-3 sm:p-4 text-sm text-green-800 relative" role="alert">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Success!</span>
                                <span class="ml-1">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-red-50 p-3 sm:p-4 text-sm text-red-800 relative" role="alert">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Error!</span>
                                <span class="ml-1">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4 rounded-lg bg-red-50 p-3 sm:p-4 text-sm text-red-800">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('store.certify', ['userid' => Auth::user()->userid]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Enhanced Search Section -->
                            <div class="relative">
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Search Certification<span class="text-red-500">*</span>
                                </label>

                                <!-- Search Input -->
                                <div class="relative">
                                    <input type="text" id="certification_search"
                                        class="w-full px-8 sm:px-12 py-3 sm:py-4 text-base sm:text-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 rounded-xl bg-gray-50 transition-all duration-200"
                                        placeholder="Search for certifications..." autocomplete="off">

                                    <!-- Search Icon -->
                                    <div class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>

                                    <!-- Loading Spinner -->
                                    <div id="search_loading"
                                        class="hidden absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-indigo-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Search Results Dropdown -->
                                <div id="search_results"
                                    class="absolute w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hidden z-50">
                                    <div id="results_container" class="max-h-60 sm:max-h-80 overflow-y-auto">
                                        @foreach ($certifications as $cert)
                                            <div class="certification-option cursor-pointer transition-colors duration-150 hover:bg-indigo-50 p-3 sm:p-4"
                                                data-id="{{ $cert->id }}" data-name="{{ $cert->name }}"
                                                data-code="{{ $cert->code }}"
                                                data-organization="{{ $cert->organization }}">
                                                <div class="flex items-center space-x-3 sm:space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m4 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm sm:text-base font-medium text-gray-900 truncate">
                                                            {{ $cert->name }}</p>
                                                        <p class="text-xs sm:text-sm text-gray-500">Code:
                                                            {{ $cert->code }}</p>
                                                    </div>
                                                    <div class="selection-icon hidden text-indigo-600">
                                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="no_results" class="hidden p-3 sm:p-4 text-center text-gray-500">
                                        No certifications found
                                    </div>
                                </div>

                                <!-- Selected Certification Display -->
                                <div id="selected_certification" class="hidden mt-4 bg-indigo-50 rounded-xl p-3 sm:p-4">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m4 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-base sm:text-lg font-medium text-indigo-900"
                                                    id="selected_cert_name"></h3>
                                                <p class="text-sm text-indigo-700" id="selected_cert_code"></p>
                                            </div>
                                        </div>
                                        <button type="button" id="change_selection"
                                            class="text-sm text-indigo-600 hover:text-indigo-800">
                                            Change
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="certification_id" id="certification_id"
                                    value="{{ old('certification_id') }}">
                                @error('certification_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Organization Field -->
                            <div class="mt-6">
                                <label for="organization" class="block mb-2 text-sm font-medium text-gray-700">
                                    Organization/Issuer<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text" id="organization" name="organization"
                                        class="w-full px-4 py-3 pl-10 sm:pl-12 text-sm sm:text-base border border-gray-200 focus:ring-2 focus:ring-indigo-500 rounded-xl bg-gray-50 transition-all duration-200"
                                        placeholder="Enter certification issuer or organization"
                                        value="{{ old('organization') }}" readonly>
                                </div>
                                @error('organization')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Certificate Upload -->
                            <div class="mt-6 sm:mt-8">
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Upload Certificate<span class="text-red-500">*</span>
                                </label>
                                <div
                                    class="mt-1 flex justify-center px-4 sm:px-6 pt-4 sm:pt-5 pb-4 sm:pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-500 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="certificate_file"
                                                class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="certificate_file" name="certificate_file" type="file"
                                                    class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, PNG, JPG up to 10MB</p>
                                    </div>
                                </div>
                                <div id="file_name" class="mt-2 text-sm text-gray-600 hidden">
                                    Selected file: <span class="font-medium"></span>
                                </div>
                                @error('certificate_file')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div
                                class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4 sm:pt-6">
                                <button type="button" onclick="window.history.back()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Submit Certification
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('certification_search');
            const searchResults = document.getElementById('search_results');
            const selectedCertification = document.getElementById('selected_certification');
            const certificationId = document.getElementById('certification_id');
            const selectedName = document.getElementById('selected_cert_name');
            const selectedCode = document.getElementById('selected_cert_code');
            const changeSelection = document.getElementById('change_selection');
            const loading = document.getElementById('search_loading');
            const resultsContainer = document.getElementById('results_container');
            const noResults = document.getElementById('no_results');
            const fileInput = document.getElementById('certificate_file');
            const fileName = document.getElementById('file_name');
            const organizationInput = document.getElementById('organization');


            // Add debounce function for search
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Search functionality with debounce
            const performSearch = debounce(function(searchTerm) {
                if (searchTerm.length < 1) {
                    searchResults.classList.add('hidden');
                    return;
                }

                loading.classList.remove('hidden');

                setTimeout(() => {
                    const options = document.querySelectorAll('.certification-option');
                    let hasResults = false;

                    options.forEach(option => {
                        const name = option.dataset.name.toLowerCase();
                        const code = option.dataset.code.toLowerCase();

                        if (name.includes(searchTerm) || code.includes(searchTerm)) {
                            option.classList.remove('hidden');
                            hasResults = true;
                        } else {
                            option.classList.add('hidden');
                        }
                    });

                    if (hasResults) {
                        resultsContainer.classList.remove('hidden');
                        noResults.classList.add('hidden');
                    } else {
                        resultsContainer.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    }

                    loading.classList.add('hidden');
                    searchResults.classList.remove('hidden');
                }, 300);
            }, 300);

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                performSearch(searchTerm);
            });

            // Handle click outside search results
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });

            // Certification selection
            document.querySelectorAll('.certification-option').forEach(option => {
                option.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const code = this.dataset.code;
                    const organization = this.dataset.organization;

                    certificationId.value = id;
                    selectedName.textContent = name;
                    selectedCode.textContent = `Code: ${code}`;
                    organizationInput.value = organization;

                    searchResults.classList.add('hidden');
                    selectedCertification.classList.remove('hidden');
                    searchInput.value = '';

                    // Add selected state visual feedback
                    this.classList.add('bg-indigo-50');
                    setTimeout(() => {
                        this.classList.remove('bg-indigo-50');
                    }, 200);
                });

                // Hover effects
                option.addEventListener('mouseenter', function() {
                    this.querySelector('.selection-icon').classList.remove('hidden');
                });

                option.addEventListener('mouseleave', function() {
                    this.querySelector('.selection-icon').classList.add('hidden');
                });
            });

            // Change selection button
            changeSelection.addEventListener('click', function() {
                selectedCertification.classList.add('hidden');
                certificationId.value = '';
                searchInput.value = '';
                searchInput.focus();
            });

            // File upload handling
            const dropZone = document.querySelector('.border-dashed');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            }

            // Handle dropped files
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    handleFile(files[0]);
                }
            }

            // Handle file input change
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });

            function handleFile(file) {
                // Validate file type
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Please upload a PDF, JPG, or PNG file');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                if (file.size > maxSize) {
                    alert('File size must be less than 10MB');
                    fileInput.value = '';
                    return;
                }

                // Update UI
                fileName.querySelector('span').textContent = file.name;
                fileName.classList.remove('hidden');
                dropZone.classList.add('border-indigo-500');
            }

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                // Validate certification selection
                if (!certificationId.value) {
                    isValid = false;
                    errorMessage = 'Please select a certification';
                    searchInput.focus();
                }

                // Validate organization
                if (!organizationInput.value.trim()) {
                    isValid = false;
                    errorMessage = errorMessage ?
                        `${errorMessage}, enter the organization` :
                        'Please enter the organization';
                }

                // Validate file upload
                if (!fileInput.files || !fileInput.files[0]) {
                    isValid = false;
                    errorMessage = errorMessage ?
                        `${errorMessage}, and upload a certificate file` :
                        'Please upload a certificate file';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>
@endsection
