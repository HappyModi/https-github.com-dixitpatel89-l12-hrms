@extends('layouts.master')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="card-title mb-0">Edit Template</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('templates.update', $template->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Template Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="template_title" class="form-label">Template Title</label>
                                        <input type="text" name="template_title" class="form-control" value="{{ $template->template_title }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="company_id" class="form-label">Select Company</label>
                                        <select name="company_id" class="form-control" required>
                                            <option value="">Choose Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}" {{ $company->id == $template->company_id ? 'selected' : '' }}>
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="card-body">
                                <labelabel for="letter_body" class="ckeditor-classic"></labelabel>
                                </div><!-- end card-body -->

                                    <div class="mb-3">
                                        <label for="text_field" class="form-label">Additional Text</label>
                                        <input type="text" name="text_field" class="form-control" value="{{ $template->text_field }}">
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">Update Template</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection