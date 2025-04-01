@extends('layouts.master')

@section('content')
@section('content')
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">

                            <h4 class="card-title mb-0">Edit Company</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <!-- Company Name -->
                                    <div class="col-md-6">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $company->company_name }}" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="company_email" class="form-label">Email</label>
                                        <input type="email" name="company_email" id="company_email" class="form-control" value="{{ $company->company_email }}">
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <label for="company_phone_number" class="form-label">Phone Number</label>
                                        <input type="text" name="company_phone_number" id="company_phone_number" class="form-control" value="{{ $company->company_phone_number }}">
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-6">
                                        <label for="company_address" class="form-label">Address</label>
                                        <input type="text" name="company_address" id="company_address" class="form-control" value="{{ $company->company_address }}">
                                    </div>

                                    <!-- Website -->
                                    <div class="col-md-6">
                                        <label for="company_website" class="form-label">Website</label>
                                        <input type="text" name="company_website" id="company_website" class="form-control" value="{{ $company->company_website }}">
                                    </div>

                                    <!-- Established Year -->
                                    <div class="col-md-6">
                                        <label for="company_established" class="form-label">Established Year</label>
                                        <input type="number" name="company_established" id="company_established" class="form-control" value="{{ $company->company_established }}">
                                    </div>

                                    <!-- CEO Name -->
                                    <div class="col-md-6">
                                        <label for="company_ceo" class="form-label">CEO Name</label>
                                        <input type="text" name="company_ceo" id="company_ceo" class="form-control" value="{{ $company->company_ceo }}">
                                    </div>

                                    <!-- Number of Employees -->
                                    <div class="col-md-6">
                                        <label for="company_employees" class="form-label">Number of Employees</label>
                                        <input type="number" name="company_employees" id="company_employees" class="form-control" value="{{ $company->company_employees }}">
                                    </div>

                                    <!-- Revenue -->
                                    <div class="col-md-6">
                                        <label for="company_revenue" class="form-label">Revenue</label>
                                        <input type="text" name="company_revenue" id="company_revenue" class="form-control" value="{{ $company->company_revenue }}">
                                    </div>

                                    <!-- Industry -->
                                    <div class="col-md-6">
                                        <label for="company_industry" class="form-label">Industry</label>
                                        <input type="text" name="company_industry" id="company_industry" class="form-control" value="{{ $company->company_industry }}">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label for="company_status" class="form-label">Status</label>
                                        <select name="company_status" id="company_status" class="form-control">
                                            <option value="Active" {{ $company->company_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $company->company_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="letterhead">Upload Letterhead</label>
                                        <input type="file" name="letterhead" id="letterhead" class="form-control">

                                        @if($company->letterhead)
                                            <p class="mt-2">Current Letterhead:</p>
                                            <img src="{{ asset('storage/' . $company->letterhead) }}" alt="Letterhead" width="200">
                                        @endif
                                    </div>
                                    <!-- Company Logo -->
                                    <div class="col-md-6">
                                        <label for="logo" class="form-label">Company Logo</label>
                                        <input type="file" name="logo" id="logo" class="form-control">
                                        @if($company->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset($company->logo) }}" width="100" height="100" class="rounded border" alt="Logo">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('companies.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div> <!-- End card-body -->
                    </div> <!-- End card -->
                </div> <!-- End col -->
            </div> <!-- End row -->
        </div> <!-- End container-fluid -->
    </div> <!-- End page-content -->
@endsection
