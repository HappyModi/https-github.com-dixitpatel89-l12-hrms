@extends('layouts.master')

@section('title', 'Employee List')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Employee List</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{ $employees->links() }}
                        </div>

                        <div class="card-body">
                            <div id="employeeList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('employees.create') }}" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i> Add
                                            </a>
                                            <button class="btn btn-soft-danger" id="deleteSelected">
                                                <i class="ri-delete-bin-2-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search" placeholder="Search...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="employeeTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                                    </div>
                                                </th>
                                                <th class="sort">Company</th>
                                                <th class="sort">Employee Name</th>
                                                <th class="sort">Email</th>
                                                <th class="sort">Phone Number</th>
                                                <th class="sort">Joining Date</th>
                                                <th class="sort">Status</th>
                                                <th class="sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-item" type="checkbox"
                                                                name="chk_child" value="{{ $employee->id }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ optional($employee->company)->name ?? 'N/A' }}</td>
                                                    <td>{{ $employee->full_name }}</td>
                                                    <td>{{ $employee->employee_email }}</td>
                                                    <td>{{ $employee->phone_number ?? 'N/A' }}</td>
                                                    <td>{{ $employee->employment_date }}</td>
                                                    <td>
                                                        <button class="border-0 bg-transparent toggle-status"
                                                            data-id="{{ $employee->id }}"
                                                            data-status="{{ $employee->status == 'Active' ? 'Inactive' : 'Active' }}">
                                                            @if ($employee->status == 'Active')
                                                                <i class="ri-toggle-fill text-danger fs-2"></i>
                                                            @else
                                                                <i class="ri-toggle-line text-success fs-2"></i>
                                                            @endif
                                                        </button>
                                                    </td>




                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-primary px-3 py-1">View</a>

                                                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-success px-3 py-1">Edit</a>

                                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger px-3 py-1">Remove</button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">No matching records found.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    {{ $employees->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Search Functionality
            document.querySelector(".search").addEventListener("input", function () {
                let searchValue = this.value.toLowerCase();
                let rows = document.querySelectorAll("#employeeTable tbody tr");
                let noResultDiv = document.querySelector(".noresult");
                let found = false;

                rows.forEach(row => {
                    let rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchValue)) {
                        row.style.display = "";
                        found = true;
                    } else {
                        row.style.display = "none";
                    }
                });

                noResultDiv.style.display = found ? "none" : "block";
            });

            // Select All Checkbox
            document.getElementById("checkAll").addEventListener("click", function () {
                let checkboxes = document.querySelectorAll(".checkbox-item");
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            // Delete Selected Employees
            document.getElementById("deleteSelected").addEventListener("click", function () {
                let selectedIds = [];
                document.querySelectorAll(".checkbox-item:checked").forEach(checkbox => {
                    selectedIds.push(checkbox.value);
                });

                if (selectedIds.length > 0 && confirm("Are you sure you want to delete selected employees?")) {
                    fetch("{{ route('employees.deleteMultiple') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Employees deleted successfully!");
                                location.reload();
                            } else {
                                alert("Error deleting employees.");
                            }
                        });
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".toggle-status").forEach(button => {
                button.addEventListener("click", function () {
                    let employeeId = this.getAttribute("data-id");
                    let newStatus = this.getAttribute("data-status");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to change the status!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Change it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/employees/${employeeId}/status`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({ status: newStatus })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: "Updated!",
                                            text: `Employee status changed to ${newStatus}.`,
                                            icon: "success",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });

                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        Swal.fire("Error!", "Status change failed.", "error");
                                    }
                                });
                        }
                    });
                });
            });
        });





    </script>
@endsection