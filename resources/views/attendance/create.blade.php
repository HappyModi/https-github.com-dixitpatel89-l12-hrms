@extends('layouts.master')

@section('title', 'Add Attendance')

@section('content')
        <div class="container">
            <h4 class="mb-4">Add Employee Attendance</h4>

            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                        @endforeach
                    </select>


                </div>

                <div class="mb-3">
                    <label class="form-label">Previous Month ({{ \Carbon\Carbon::now()->subMonth()->format('F Y') }})</label>
                    <input type="text" class="form-control" id="prev_month_working_days" name="prev_month_working_days" readonly>
                    <input type="text" class="form-control mt-2" id="prev_month_leave_days" name="prev_month_leave_days" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Month ({{ \Carbon\Carbon::now()->format('F Y') }})</label>
                    <input type="number" class="form-control" name="current_month_working_days" placeholder="Working Days" required>
                    <input type="number" class="form-control mt-2" name="current_month_leave_days" placeholder="Leave Days" required>
                </div>

                <button type="submit" class="btn btn-primary">Save Attendance</button>
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>

        <script>
        function loadEmployees() {
            fetch("{{ route('attendance.getEmployees') }}") 
                .then(response => response.json())
                .then(data => {
                    let dropdown = document.getElementById("employee_id");
                    dropdown.innerHTML = '<option value="" disabled selected>Select Employee</option>'; // Reset dropdown

                    if (data.length === 0) {
                        dropdown.innerHTML += '<option value="">No employees available</option>';
                    } else {
                        data.forEach(employee => {
                            dropdown.innerHTML += `<option value="${employee.id}">${employee.id} - ${employee.full_name}</option>`;
                        });
                    }
                })
                .catch(error => console.error("Error fetching employees:", error));
        }

        // Load employees when the page loads
        document.addEventListener('DOMContentLoaded', loadEmployees);
    </script>

@endsection
