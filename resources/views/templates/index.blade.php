@extends('layouts.master')

@section('title', 'Template Master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Template Master</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#templateModal">
                                Add Template
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Company</th>
                                            <th>Letterhead</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($templates as $template)
                                            <tr>
                                                <td>{{ $template->name }}</td>
                                                <td>{{ $template->template_title }}</td>
                                                <td>{{ $template->company->company_name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($template->company && $template->company->letterhead)
                                                        <img src="{{ asset('storage/' . $template->company->letterhead) }}" width="100">
                                                    @else
                                                        No Letterhead
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <form action="{{ route('templates.destroy', $template->id) }}" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this template?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- End table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Modal -->
    <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateModalLabel">Add Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('templates.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Template Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="template_title" class="form-label">Template Title</label>
                            <input type="text" name="template_title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="company_id" class="form-label">Select Company</label>
                            <select name="company_id" class="form-select" required>
                                <option value="">-- Select Company --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="letter_body" class="form-label">Letter Body</label>
                            <textarea name="letter_body" id="editor"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Template</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    CKEDITOR.replace('editor');
</script>
@endsection
