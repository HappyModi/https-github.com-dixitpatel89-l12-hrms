@extends('layouts.master')

@section('title', 'Attendance List')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Employee Attendance</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Previous Month Working Days</th>
                                        <th>Previous Month Leave Days</th>
                                        <th>Current Month Working Days</th>
                                        <th>Current Month Leave Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->employee->id }}</td>
                                            <td>{{ $attendance->employee->full_name }}</td>
                                            <td>{{ $attendance->prev_working_days }}</td>
                                            <td>{{ $attendance->prev_leave_days }}</td>
                                            <td>{{ $attendance->current_working_days }}</td>
                                            <td>{{ $attendance->current_leave_days }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <a href="{{ route('attendance.create') }}" class="btn btn-primary mt-3">
                                <i class="ri-add-circle-line"></i> Add Attendance
                            </a>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- End Container -->
    </div> <!-- End Page Content -->
@endsection
