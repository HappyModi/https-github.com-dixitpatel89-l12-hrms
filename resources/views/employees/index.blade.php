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
                                            <input type="text" class="form-control search" id="searchInput" placeholder="Search...">
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
                                                    <td>{{ optional($employee->company)->company_name ?? 'N/A' }}</td>
                                                    <td>{{ $employee->full_name }}</td>
                                                    <td>{{ $employee->employee_email }}</td>
                                                    <td>{{ $employee->phone_number ?? 'N/A' }}</td>
                                                    <td>{{ $employee->employment_date }}</td>
                                                    <td>
                                                        <button class="border-0 bg-transparent toggle-status" data-id="{{ $employee->id }}"
                                                            data-status="{{ $employee->status }}">
                                                            @if ($employee->status == 'Active')
                                                                <i class="ri-toggle-fill text-success fs-2"></i>
                                                            @else
                                                                <i class="ri-toggle-line text-danger fs-2"></i>
                                                            @endif
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('employees.show', $employee->id) }}"
                                                                class="btn btn-sm btn-primary px-3 py-1">View</a>
                                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                                class="btn btn-sm btn-success px-3 py-1">Edit</a>

                                                            <form action="{{ route('employees.destroy', $employee->id) }}"
                                                                method="POST" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger px-3 py-1 delete-employee">Remove</button>
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

            // Handle "Remove" Button Click
            document.querySelectorAll(".delete-employee").forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    let form = this.closest("form");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action cannot be undone!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });

        document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-status").forEach(button => {
        button.addEventListener("click", function () {
            let employeeId = this.getAttribute("data-id");
            let buttonElement = this;

            fetch(`/employees/${employeeId}/toggle-status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "Active") {
                    buttonElement.innerHTML = '<i class="ri-toggle-fill text-success fs-2"></i>';
                } else {
                    buttonElement.innerHTML = '<i class="ri-toggle-line text-danger fs-2"></i>';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Search functionality
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll("#employeeTable tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if (text.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        // Show "No Result Found" message if no rows match
        let visibleRows = [...rows].some(row => row.style.display !== "none");
        document.querySelector(".noresult").style.display = visibleRows ? "none" : "block";
    });
});


</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

// Handle "Select All" Checkbox
document.getElementById("checkAll").addEventListener("change", function () {
    let checkboxes = document.querySelectorAll(".checkbox-item");
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// Handle "Delete Selected" Button Click
document.getElementById("deleteSelected").addEventListener("click", function () {
    let selectedIds = [];
    document.querySelectorAll(".checkbox-item:checked").forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });

    if (selectedIds.length === 0) {
        Swal.fire("No Employee Selected", "Please select at least one employee to delete.", "warning");
        return;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('employees.bulkDelete') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ employee_ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selectedIds.forEach(id => {
                        document.querySelector(`input[value="${id}"]`).closest("tr").remove();
                    });
                    Swal.fire("Deleted!", "Selected employees have been deleted.", "success");
                } else {
                    Swal.fire("Error", "Something went wrong. Try again.", "error");
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

});
</script>


@endsection