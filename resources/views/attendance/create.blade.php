@extends('layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                            <h2 class="mb-0">Add Attendance</h2>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('attendance.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="number" name="employee_id" id="employee_id" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="ctc" class="form-label">CTC</label>
                                    <input type="text" name="ctc" id="ctc" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="performance_bonus" class="form-label">Performance Bonus</label>
                                    <input type="text" name="performance_bonus" id="performance_bonus" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="leave_encashment" class="form-label">Leave Encashment</label>
                                    <input type="text" name="leave_encashment" id="leave_encashment" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
