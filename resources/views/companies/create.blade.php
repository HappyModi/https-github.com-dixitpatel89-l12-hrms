@extends('layouts.master')

@section('content')
<style>
    .container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        padding: 30px;
        background: #f4f7fc;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
    }

    .container h2 {
        text-align: center;
        color: #003366;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        padding: 10px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
        color: #003366;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        border: 2px solid #ccd6eb;
        border-radius: 6px;
        background: #f9fbff;
    }

    .submit-btn {
        display: block;
        width: 100%;
        background: linear-gradient(to right, #0044cc, #002b80);
        color: white;
        padding: 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
    }
</style>

<div class="container">
    <h2>Add Company</h2>
    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Company Details Section -->
        <h3>Company Details</h3>
        <div class="form-grid">
            <div class="form-group"><label>Company Name</label><input type="text" name="company_name" required></div>
            <div class="form-group"><label>Logo</label><input type="file" name="logo"></div>
            <div class="form-group"><label>Phone Number</label><input type="text" name="company_phone_number"></div>
            <div class="form-group"><label>Email</label><input type="email" name="company_email"></div>
            <div class="form-group"><label>Website</label><input type="text" name="website"></div>
            <div class="form-group"><label>Industry</label><input type="text" name="industry"></div>
            <div class="form-group"><label>Description</label><textarea name="company_description"></textarea></div>
            <div class="form-group"><label>Company Type</label><select name="company_type">
                <option value="Private">Private</option>
                <option value="Public">Public</option>
                <option value="Government">Government</option>
                <option value="NGO">NGO</option>
                <option value="Startup">Startup</option>
            </select></div>
            <div class="form-group"><label>Status</label><select name="company_status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select></div>
        </div>

        <!-- Address Section -->
        <h3>Address</h3>
        <div class="form-grid">
            <div class="form-group"><label>Address Line 1</label><input type="text" name="address_line_1"></div>
            <div class="form-group"><label>Address Line 2</label><input type="text" name="address_line_2"></div>
            <div class="form-group"><label>City</label><input type="text" name="company_city"></div>
            <div class="form-group"><label>State</label><input type="text" name="company_state"></div>
            <div class="form-group"><label>Country</label><input type="text" name="company_country"></div>
            <div class="form-group"><label>Zip Code</label><input type="text" name="company_zip_code"></div>
        </div>
        
        <!-- Bank Details Section -->
        <h3>Bank Details</h3>
        <div class="form-grid">
            <div class="form-group"><label>Bank Name</label><input type="text" name="company_bank_name"></div>
            <div class="form-group"><label>Bank Account Number</label><input type="text" name="company_bank_account_no"></div>
            <div class="form-group"><label>IFSC Code</label><input type="text" name="company_ifsc_code"></div>
        </div>
        
        <!-- Additional Details -->
        <h3>Additional Details</h3>
        <div class="form-grid">
            <div class="form-group"><label>Tax ID</label><input type="text" name="company_tax_id"></div>
            <div class="form-group"><label>Registration Number</label><input type="text" name="company_registration_number"></div>
            <div class="form-group"><label>HR Contact</label><input type="text" name="company_hr_contact"></div>
            <div class="form-group"><label>Finance Contact</label><input type="text" name="company_finance_contact"></div>
            <div class="form-group"><label>Support Email</label><input type="email" name="company_support_email"></div>
            <div class="form-group"><label>Support Phone</label><input type="text" name="company_support_phone"></div>
            <div class="form-group"><label>Legal Name</label><input type="text" name="company_legal_name"></div>
            <div class="form-group"><label>Tax Percentage</label><input type="text" name="company_tax_percentage"></div>
            <div class="form-group"><label>Currency</label><input type="text" name="company_currency"></div>
            <div class="form-group"><label>GST Number</label><input type="text" name="gst_number"></div>
            <div class="form-group"><label>EPFO Number</label><input type="text" name="epfo_number"></div>
            <div class="form-group"><label>CIN Number</label><input type="text" name="cin_number"></div>
            <div class="form-group"><label>PAN Number</label><input type="text" name="company_pan_number"></div>
            <div class="form-group"><label>Founded Date</label><input type="date" name="founded_date"></div>
            
            <!-- Letterhead Upload -->
            <div class="form-group">
                <label>Upload Letterhead</label>
                <input type="file" name="letterhead">
            </div>
            
            <!-- Display Existing Letterhead -->
            @if(isset($company->letterhead))
                <div class="form-group">
                    <label>Current Letterhead</label>
                    <img src="{{ asset('storage/'.$company->letterhead) }}" class="img-thumbnail" width="200">
                </div>
            @endif
        </div>
        
        <div class="text-center mt-4">
            <button type="submit" class="submit-btn">Submit</button>
        </div>
    </form>
</div>
@endsection
