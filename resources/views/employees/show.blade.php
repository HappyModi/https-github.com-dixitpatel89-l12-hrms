@extends('layouts.master')

@section('title', 'View Employee')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Sidebar (Dropdown for Documents) -->
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Employee Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="documentType" class="form-label">Select Document</label>
                                <select id="documentType" class="form-select">
                                    <option value="" selected disabled>Choose Document...</option>
                                    <option value="offer_letter">Offer Letter</option>
                                    <option value="appointment_letter">Appointment Letter</option>
                                    <option value="experience_letter">Experience Letter</option>
                                    <option value="appraisal_letter">Appraisal Letter</option>
                                    <option value="confirmation_letter">Confirmation Letter</option>
                                    <option value="relieving_letter">Relieving Letter</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content (Employee Details & Dynamic Form) -->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Employee Details</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Company:</th>
                                    <td>{{ optional($employee->company)->company_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $employee->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $employee->employee_email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number:</th>
                                    <td>{{ $employee->phone_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Joining Date:</th>
                                    <td>{{ $employee->employment_date }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if ($employee->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Dynamic Document Form -->
                            <div id="documentForm" class="mt-4" style="display: none;">
                                <h5 class="mb-3" id="documentTitle"></h5>
                                <form id="documentGenerateForm" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="documentDate" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="documentDate" name="document_date" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="documentSalary" class="form-label">Salary</label>
                                            <input type="text" class="form-control" id="documentSalary" name="document_salary" required>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" id="generateLetterBtn" class="btn btn-primary">
                                            Generate Document
                                        </button>
                                    </div>
                                </form>
                            </div>


                            <!-- Generated Documents List -->
                            <div class="mt-4">
                                <h5 class="mb-3">Generated Documents</h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Letter Type</th>
                                            <th>Generated At</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($generatedDocuments as $index => $document)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $document->document_title)) }}</td>
                                                <td>{{ $document->created_at->format('d M Y, H:i A') }}</td>
                                                <td>
                                                    <a href="{{ route('documents.download', $document->id) }}" class="btn btn-sm btn-success">
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No documents generated yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let documentType = document.getElementById("documentType");
            let documentForm = document.getElementById("documentForm");
            let documentTitle = document.getElementById("documentTitle");
            let generateLetterBtn = document.getElementById("generateLetterBtn");

            documentType.addEventListener("change", function () {
                let selectedValue = this.value;
                if (selectedValue) {
                    documentForm.style.display = "block";
                    documentTitle.innerText = selectedValue.replace("_", " ").toUpperCase() + " Details";
                } else {
                    documentForm.style.display = "none";
                }
            });

            // Handle document generation
            generateLetterBtn.addEventListener("click", function () {
                let selectedDocument = documentType.value;
                if (!selectedDocument) {
                    alert("Please select a document type.");
                    return;
                }

                let url = "{{ route('employees.generateEmployeeLetter', ['id' => $employee->id, 'letterType' => '__LETTER_TYPE__']) }}";
                url = url.replace("__LETTER_TYPE__", selectedDocument);

                window.location.href = url;
            });
        });
    </script>
@endsection
