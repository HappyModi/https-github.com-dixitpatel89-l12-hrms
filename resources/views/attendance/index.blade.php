@extends('layouts.master')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h2 class="mb-0">Attendance Management</h2>
                    </div>
                    <div class="card-body">
                        
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Month Dropdown -->
                        <div class="mb-3">
                            <label for="month">Select Month:</label>
                            <select class="form-control" id="month" name="month">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}">{{ date("F", mktime(0, 0, 0, $m, 10)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Attendance Table -->
                        <form method="POST" action="{{ route('attendance.store') }}">
                            @csrf
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee Salary</th>
                                        <th>CTC</th>
                                        <th>Performance Bonus</th>
                                        <th>Leave Encashment</th>
                                        <th>Month Workdays</th>
                                        <th>Leave Credits</th>
                                        <th>LOP Days</th>
                                        <th>Paid Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->salary }}</td>
                                        <input type="hidden" name="employee_id[]" value="{{ $employee->id }}">
                                        <td><input type="text" name="ctc[]" value="{{ $employee->ctc }}" class="form-control"></td>
                                        <td><input type="text" name="performance_bonus[]" value="0" class="form-control"></td>
                                        <td><input type="text" name="leave_encashment[]" value="0" class="form-control"></td>
                                        <td><input type="text" name="month_workdays[]" value="30" class="form-control"></td>
                                        <td><input type="text" name="leave_credits[]" value="0" class="form-control"></td>
                                        <td><input type="text" name="lop_days[]" value="0" class="form-control"></td>
                                        <td><input type="text" name="paid_days[]" value="30" class="form-control"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <button type="submit" class="btn btn-primary mt-3">Save Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection