@extends('layouts.master')

@section('title', 'Edit Employee')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Edit Employee</h4>
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                        <div class="card-body">
                            @php
    $employeeRoles = is_array($employee->roles) ? $employee->roles : json_decode($employee->roles, true) ?? [];
                            @endphp

                            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Display Validation Errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Roles Section --}}
                                <h5 class="mb-3">Assign Roles:</h5>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="Super Admin" id="roleSuperAdmin"
                                                {{ in_array("Super Admin", $employeeRoles) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="roleSuperAdmin">Super Admin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="Employee" id="roleEmployee"
                                                {{ in_array("Employee", $employeeRoles) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="roleEmployee">Employee</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="Hr Admin" id="roleHrAdmin"
                                                {{ in_array("Hr Admin", $employeeRoles) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="roleHrAdmin">Hr Admin</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Personal Information --}}
                                <h5 class="mb-3">Personal Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="fullName" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="full_name" id="fullName"
                                            value="{{ old('full_name', $employee->full_name) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email <sup class="text-danger">*</sup></label>
                                        <input type="email" class="form-control" name="employee_email" id="email"
                                            value="{{ old('employee_email', $employee->employee_email) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            value="{{ old('phone_number', $employee->phone_number ?? '') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" name="profile_image">
                                        @if ($employee->profile_image)
                                            <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Profile Image" width="50" class="mt-2 rounded">
                                        @endif
                                    </div>
                                </div>

                                {{-- Position Details --}}
                                <h5 class="my-4">Position</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Employment Date</label>
                                        <input type="date" class="form-control" name="join_date"
                                            value="{{ old('join_date', $employee->join_date) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Release Date</label>
                                        <input type="date" class="form-control" name="release_date"
                                            value="{{ old('release_date', $employee->release_date) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="status" value="Active"
                                                    id="activeRadio" {{ $employee->status == 'Active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activeRadio">Active</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="Inactive"
                                                    id="inactiveRadio" {{ $employee->status == 'Inactive' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactiveRadio">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('employees.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
