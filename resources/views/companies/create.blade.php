@extends('layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">Add Company</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Company Details Section -->
                                <h4 class="mb-3">Company Details</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Company Name</label>
                                        <input type="text" class="form-control" name="company_name" required>
                                    </div>
                                    <div class="col-md-4">
                                    <label>Company Logo:</label>
                                    <input type="file" name="logo">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="company_phone_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="company_email">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Industry</label>
                                        <input type="text" class="form-control" name="industry">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="company_description"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-control" name="company_status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Address Section -->
                                <h4 class="mt-4">Address</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Address Line 1</label>
                                        <input type="text" class="form-control" name="address_line_1">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" name="address_line_2">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" name="company_city">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control" name="company_state">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control" name="company_country">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" name="company_zip_code">
                                    </div>
                                </div>
                                
                                <!-- Bank Details Section -->
                                <h4 class="mt-4">Bank Details</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" name="company_bank_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Bank Account Number</label>
                                        <input type="text" class="form-control" name="company_bank_account_no">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" class="form-control" name="company_ifsc_code">
                                    </div>
                                </div>
                                
                                <!-- Additional Details -->
                                <h4 class="mt-4">Additional Details</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">GST Number</label>
                                        <input type="text" class="form-control" name="gst_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">EPFO Number</label>
                                        <input type="text" class="form-control" name="epfo_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">CIN Number</label>
                                        <input type="text" class="form-control" name="cin_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">PAN Number</label>
                                        <input type="text" class="form-control" name="company_pan_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Founded Date</label>
                                        <input type="date" class="form-control" name="founded_date">
                                    </div>
                                    
                                    <!-- Letterhead Upload -->
                                    <div class="col-md-4">
                                        <label class="form-label">Upload Letterhead</label>
                                        <input type="file" class="form-control" name="letterhead">
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div> <!-- End Card Body -->
                    </div> <!-- End Card -->
                </div> <!-- End Col -->
            </div> <!-- End Row -->
        </div> <!-- End Container -->
    </div> <!-- End Page Content -->
@endsection
