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
                                    <td>{{ optional($employee->company)->name ?? 'N/A' }}</td>
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
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="documentDate" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="documentDate">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="documentSalary" class="form-label">Salary</label>
                                            <input type="text" class="form-control" id="documentSalary">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Generate Document</button>
                                    </div>
                                </form>
                            </div>

                            <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back to List</a>
                        </div>
                    </div>

                    <!-- Salary Slip Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Salary Slip</h4>
                        </div>
                        <div class="card-body">
                            <form id="salarySlipForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="salaryMonth" class="form-label">Month</label>
                                        <input type="month" class="form-control" id="salaryMonth">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leaveDays" class="form-label">Leave Days</label>
                                        <input type="number" class="form-control" id="leaveDays">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="netSalary" class="form-label">Net Salary</label>
                                        <input type="text" class="form-control" id="netSalary">
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" id="generatePdf" class="btn btn-danger">
                                        <i class="ri-file-pdf-line"></i> Generate PDF
                                    </button>
                                </div>
                            </form>
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

            documentType.addEventListener("change", function () {
                let selectedValue = this.value;

                if (selectedValue) {
                    documentForm.style.display = "block";
                    if (selectedValue === "offer_letter") {
                        documentTitle.innerText = "Offer Letter Details";
                    } else if (selectedValue === "appointment_letter") {
                        documentTitle.innerText = "Appointment Letter Details";
                    } else if (selectedValue === "experience_letter") {
                        documentTitle.innerText = "Experience Letter Details";
                    }
                } else {
                    documentForm.style.display = "none";
                }
            });

            // Generate PDF for Salary Slip
            document.getElementById("generatePdf").addEventListener("click", function () {
                let salaryMonth = document.getElementById("salaryMonth").value;
                let leaveDays = document.getElementById("leaveDays").value;
                let netSalary = document.getElementById("netSalary").value;

                if (!salaryMonth || !leaveDays || !netSalary) {
                    alert("Please fill all salary slip details.");
                    return;
                }

                fetch("{{ route('employees.generateSalaryPdf', $employee->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        month: salaryMonth,
                        leave_days: leaveDays,
                        salary: netSalary
                    })
                })
                .then(response => response.blob())
                .then(blob => {
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement("a");
                    a.href = url;
                    a.download = "SalarySlip.pdf";
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                })
                .catch(error => {
                    alert("Error generating PDF.");
                    console.error(error);
                });
            });
        });
    </script>
@endsection
