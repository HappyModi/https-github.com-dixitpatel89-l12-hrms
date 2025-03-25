@extends('layouts.master')

@section('content')
<div class="container">
    <h2>{{ $company->company_name }}</h2>
    <p><strong>Phone:</strong> {{ $company->company_phone_number }}</p>
    <p><strong>Email:</strong> {{ $company->company_email }}</p>
    <p><strong>Address:</strong> {{ $company->address_line_1 }}, {{ $company->company_city }}, {{ $company->company_state }}</p>
    <p><strong>Industry:</strong> {{ $company->industry }}</p>
    <p><strong>Company Type:</strong> {{ $company->company_type }}</p>
    <p><strong>Status:</strong> {{ $company->company_status }}</p>
    <a href="{{ route('companies.index') }}" class="btn btn-primary">Back to Companies</a>
</div>
@endsection
