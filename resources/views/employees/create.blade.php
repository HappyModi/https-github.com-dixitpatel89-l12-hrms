@extends('layouts.master')

@section('title', 'Add User')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Add User</h4>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Company Name</label>
                                    <select class="form-control" name="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="employee_email" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Salary</label>
                                    <input type="number" class="form-control" name="salary">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Emergency Contact</label>
                                    <input type="text" class="form-control" name="emergency_contact">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Emergency Contact Name</label>
                                    <input type="text" class="form-control" name="emergency_contact_name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number"
                                        value="{{ old('phone_number', $employee->phone_number ?? '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_image">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Address Proof</label>
                                    <input type="file" class="form-control" name="address_proof">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Identity Proof</label>
                                    <input type="file" class="form-control" name="identity_proof">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Employment Date</label>
                                    <input type="date" class="form-control" name="employment_date">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Release Date</label>
                                    <input type="date" class="form-control" name="release_date">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection