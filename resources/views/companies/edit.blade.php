@extends('layouts.master')

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

                                    <!-- Company Status -->
                                    <div class="col-md-6">
                                        <label for="company_status" class="form-label">Company Status</label>
                                        <select name="company_status" id="company_status" class="form-control">
                                            <option value="active" {{ $company->company_status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $company->company_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Company Logo -->
                                    <div class="col-md-6">
                                        <label for="company_logo" class="form-label">Company Logo</label>
                                        <input type="file" name="company_logo" id="company_logo" class="form-control">

                                        @if($company->logo)
                                            <p class="mt-2">Current Logo:</p>
                                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" width="100">
                                        @else
                                            <p class="mt-2 text-danger">No Logo Available</p>
                                        @endif
                                    </div>
                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <label for="company_description" class="form-label">Description</label>
                                        <textarea name="company_description" id="company_description" class="form-control">{{ $company->company_description }}</textarea>
                                    </div>

                                    <!-- Address Fields -->
                                    <div class="col-md-6">
                                        <label for="address_line_1" class="form-label">Address Line 1</label>
                                        <input type="text" name="address_line_1" id="address_line_1" class="form-control" value="{{ $company->address_line_1 }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address_line_2" class="form-label">Address Line 2</label>
                                        <input type="text" name="address_line_2" id="address_line_2" class="form-control" value="{{ $company->address_line_2 }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_city" class="form-label">City</label>
                                        <input type="text" name="company_city" id="company_city" class="form-control" value="{{ $company->company_city }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_state" class="form-label">State</label>
                                        <input type="text" name="company_state" id="company_state" class="form-control" value="{{ $company->company_state }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_country" class="form-label">Country</label>
                                        <input type="text" name="company_country" id="company_country" class="form-control" value="{{ $company->company_country }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_zip_code" class="form-label">Zip Code</label>
                                        <input type="text" name="company_zip_code" id="company_zip_code" class="form-control" value="{{ $company->company_zip_code }}">
                                    </div>

                                    <!-- Bank Details -->
                                    <div class="col-md-6">
                                        <label for="company_bank_name" class="form-label">Bank Name</label>
                                        <input type="text" name="company_bank_name" id="company_bank_name" class="form-control" value="{{ $company->company_bank_name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_bank_account_no" class="form-label">Bank Account Number</label>
                                        <input type="text" name="company_bank_account_no" id="company_bank_account_no" class="form-control" value="{{ $company->company_bank_account_no }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_ifsc_code" class="form-label">IFSC Code</label>
                                        <input type="text" name="company_ifsc_code" id="company_ifsc_code" class="form-control" value="{{ $company->company_ifsc_code }}">
                                    </div>

                                    <!-- Additional Details -->
                                    <div class="col-md-6">
                                        <label for="company_hr_contact" class="form-label">HR Contact</label>
                                        <input type="text" name="company_hr_contact" id="company_hr_contact" class="form-control" value="{{ $company->company_hr_contact }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gst_number" class="form-label">GST Number</label>
                                        <input type="text" name="gst_number" id="gst_number" class="form-control" value="{{ $company->gst_number }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="epfo_number" class="form-label">EPFO Number</label>
                                        <input type="text" name="epfo_number" id="epfo_number" class="form-control" value="{{ $company->epfo_number }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cin_number" class="form-label">CIN Number</label>
                                        <input type="text" name="cin_number" id="cin_number" class="form-control" value="{{ $company->cin_number }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_pan_number" class="form-label">PAN Number</label>
                                        <input type="text" name="company_pan_number" id="company_pan_number" class="form-control" value="{{ $company->company_pan_number }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="founded_date" class="form-label">Founded Date</label>
                                        <input type="date" name="founded_date" id="founded_date" class="form-control" value="{{ $company->founded_date }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="letterhead">Upload Letterhead</label>
                                    <input type="file" name="letterhead" id="letterhead" class="form-control">

                                    @if($company->letterhead)
                                        <p class="mt-2">Current Letterhead:</p>
                                        <img src="{{ asset('storage/' . $company->letterhead) }}" alt="Letterhead" width="200">
                                    @endif
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('companies.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
