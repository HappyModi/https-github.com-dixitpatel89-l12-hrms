@extends('layouts.master')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add New Template</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('templates.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Template Name:</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Company ID:</label>
                                    <input type="text" name="company_id" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Letter Body:</label>
                                    <textarea name="letter_body" id="editor" class="form-control"></textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Template</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endsection
