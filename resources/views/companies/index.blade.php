@extends('layouts.master')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Employee List</h4>
                    </div>

                    <div class="card-body">
                        <div id="employeeList">
                            <div class="row g-4 mb-3">
                                <!-- Left side: Add and Delete buttons -->
                                <div class="col-sm-auto">
                                    <div class="d-flex">
                                        <a href="{{ route('companies.create') }}" class="btn btn-success">
                                            <i class="ri-add-line align-bottom me-1"></i> Add
                                        </a>
                                        <button class="btn btn-soft-danger ms-2" id="deleteSelected">
                                            <i class="ri-delete-bin-2-line"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Right side: Search box -->
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box position-relative">
                                            <input type="text" id="searchInput" class="form-control search ps-4" placeholder="Search...">
                                            <i class="ri-search-line search-icon position-absolute top-50 start-0 translate-middle-y ms-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="bulk-delete-form" action="{{ route('companies.bulkDelete') }}" method="POST">
                                @csrf
                                <table class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr class="text-center">
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>#</th>
                                            <th>Logo</th>
                                            <th>Company Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="companyTable">
                                        @foreach($companies as $key => $company)
                                        <tr class="text-center">
                                            <td><input type="checkbox" name="selected_companies[]" value="{{ $company->id }}" class="company-checkbox"></td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if($company->logo)
                                                    <img src="{{ asset($company->logo) }}" width="40" height="40" alt="Logo" class="rounded-circle">
                                                @else
                                                    <span>No Logo</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ $company->company_name }}</strong></td>
                                            <td>{{ $company->company_email }}</td>
                                            <td>{{ $company->company_phone_number }}</td>
                                            <td>
                                                <span class="badge bg-primary text-uppercase">{{ $company->company_status }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-success px-3 py-1">Edit</a>
                                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach

                                        <!-- No Data Row -->
                                        <tr id="noDataRow" class="text-center" style="display: none;">
                                            <td colspan="8"><strong>No data found</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div> <!-- End employeeList -->
                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div> <!-- End col -->
        </div> <!-- End row -->
    </div> <!-- End container-fluid -->
</div> <!-- End page-content -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.company-checkbox');
        const deleteButton = document.getElementById('deleteSelected');
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll("#companyTable tr:not(#noDataRow)");
        const noDataRow = document.getElementById("noDataRow");

        // Select All Checkbox Logic
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            toggleDeleteButton();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleDeleteButton);
        });

        function toggleDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            deleteButton.disabled = !anyChecked;
        }

        // Search Functionality
        searchInput.addEventListener("keyup", function () {
            let filter = searchInput.value.toLowerCase();
            let visibleRows = 0;

            tableRows.forEach(row => {
                let text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = "";
                    visibleRows++;
                } else {
                    row.style.display = "none";
                }
            });

            // Show "No data found" row if no matches
            noDataRow.style.display = visibleRows === 0 ? "" : "none";
        });

        // Bulk Delete Functionality
        deleteButton.addEventListener('click', function () {
            let selectedIds = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            });

            if (selectedIds.length > 0 && confirm('Are you sure you want to delete selected companies?')) {
                selectedIds.forEach(companyId => {
                    fetch(`{{ url('companies') }}/${companyId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ _method: "DELETE" }) // Simulating DELETE request
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`input[value="${companyId}"]`).closest("tr").remove();
                        } else {
                            alert(`Error deleting company ID ${companyId}`);
                        }
                    });
                });
            }
        });
    });
</script>

@endsection
