@extends('layouts.adminsidebar')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Container -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Header Section -->
                <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-200">
                    <div class="flex flex-col space-y-1.5">
                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-900">
                            Upload Certifications
                        </h3>
                        <p class="text-sm sm:text-base text-gray-500">
                            Import certification data using Excel file (.xlsx, .xls)
                        </p>
                    </div>
                </div>

                <!-- Upload Form Section -->
                <div class="px-6 py-6 sm:px-8 sm:py-7">
                    <form id="uploadForm" action="{{ route('uploadformdata') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Upload Drop Zone -->
                            <div
                                class="mt-1 flex justify-center px-6 py-8 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-500 transition-colors duration-200">
                                <div class="space-y-2 text-center">
                                    <!-- Upload Icon -->
                                    <svg class="mx-auto h-12 w-12 sm:h-14 sm:w-14 text-gray-400" stroke="currentColor"
                                        fill="none" viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <!-- Upload Instructions -->
                                    <div
                                        class="flex flex-col sm:flex-row items-center justify-center text-sm sm:text-base space-y-2 sm:space-y-0 sm:space-x-2">
                                        <label for="file-upload"
                                            class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none transition-colors duration-150">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file" type="file" class="sr-only"
                                                accept=".xlsx,.xls">
                                        </label>
                                        <p class="text-gray-600">or drag and drop</p>
                                    </div>

                                    <!-- File Type Info -->
                                    <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                        Excel files only (.xlsx, .xls)
                                    </p>

                                    <!-- Selected File Name -->
                                    <p id="selected-file-name" class="text-sm text-indigo-600 font-medium mt-2 hidden"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Preview Section -->
                <div class="px-6 sm:px-8 py-6 hidden" id="previewSection">
                    <div class="space-y-4">
                        <!-- Preview Header -->
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg sm:text-xl font-semibold text-gray-900">Preview Data</h4>
                            <span id="row-count" class="text-sm text-gray-500"></span>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="w-2/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Code
                                        </th>
                                        <th scope="col"
                                            class="w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Organization
                                        </th>
                                        <th scope="col"
                                            class="w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="previewBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Data rows will be inserted here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancelButton"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                Cancel
                            </button>
                            <button type="button" id="submitButton"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                Upload Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileUpload = document.getElementById('file-upload');
            const previewSection = document.getElementById('previewSection');
            const previewBody = document.getElementById('previewBody');
            const submitButton = document.getElementById('submitButton');
            const cancelButton = document.getElementById('cancelButton');
            const selectedFileName = document.getElementById('selected-file-name');
            const rowCount = document.getElementById('row-count');
            const dropZone = document.querySelector('.border-dashed');
            let parsedData = [];

            // Drag and drop handling
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
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

            // File upload handling
            fileUpload.addEventListener('change', handleFileSelect);
            dropZone.addEventListener('drop', handleDrop);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length) {
                    fileUpload.files = files;
                    handleFileSelect({
                        target: fileUpload
                    });
                }
            }

            function handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    // Show selected filename
                    selectedFileName.textContent = `Selected: ${file.name}`;
                    selectedFileName.classList.remove('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        try {
                            const data = new Uint8Array(e.target.result);
                            const workbook = XLSX.read(data, {
                                type: 'array'
                            });
                            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                            parsedData = XLSX.utils.sheet_to_json(firstSheet);

                            // Display preview
                            displayPreview(parsedData);
                            previewSection.classList.remove('hidden');
                            rowCount.textContent = `${parsedData.length} records found`;
                        } catch (error) {
                            alert('Error reading file. Please ensure it\'s a valid Excel file.');
                            console.error('File reading error:', error);
                        }
                    };
                    reader.readAsArrayBuffer(file);
                }
            }

            function displayPreview(data) {
                previewBody.innerHTML = '';
                data.forEach((row, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td class="px-6 py-4">
                    <input type="text" name="certifications[${index}][name]" value="${row.name || ''}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="certifications[${index}][code]" value="${row.code || ''}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="certifications[${index}][organization]" value="${row.organization || ''}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </td>
                <td class="px-6 py-4">
                    <button type="button" onclick="deleteRow(this)"
                            class="text-red-600 hover:text-red-900 focus:outline-none focus:underline transition-colors duration-150">
                        Delete
                    </button>
                </td>
            `;
                    previewBody.appendChild(tr);
                });
            }

            submitButton.addEventListener('click', function() {
                if (!confirm('Are you sure you want to upload these certifications?')) return;

                const formData = new FormData();
                const certifications = [];

                document.querySelectorAll('#previewBody tr').forEach(row => {
                    const certification = {
                        name: row.querySelector('input[name$="[name]"]').value.trim(),
                        code: row.querySelector('input[name$="[code]"]').value.trim(),
                        organization: row.querySelector('input[name$="[organization]"]').value
                            .trim()
                    };
                    certifications.push(certification);
                });

                if (certifications.length === 0) {
                    alert('Please add at least one certification.');
                    return;
                }

                formData.append('certifications', JSON.stringify(certifications));
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                // Disable submit button and show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Uploading...
        `;

                fetch('{{ route('uploadformdata') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '{{ route('addcert') }}';
                        } else {
                            alert(data.message || 'Error saving certifications');
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Upload Data';
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        alert('An error occurred while uploading the data');
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Upload Data';
                    });
            });

            cancelButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
                    window.location.href = '{{ route('addcert') }}';
                }
            });
        });

        function deleteRow(button) {
            const row = button.closest('tr');
            row.classList.add('fade-out');
            setTimeout(() => {
                row.remove();
                updateRowCount();
            }, 150);
        }

        function updateRowCount() {
            const count = document.querySelectorAll('#previewBody tr').length;
            document.getElementById('row-count').textContent = `${count} records found`;
        }
    </script>

    <style>
        .fade-out {
            opacity: 0;
            transform: translateX(20px);
            transition: opacity 150ms ease-in-out, transform 150ms ease-in-out;
        }
    </style>
@endsection
