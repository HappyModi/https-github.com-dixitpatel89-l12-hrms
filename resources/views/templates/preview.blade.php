@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Letter Preview</h5>
            <button class="btn btn-light btn-sm" onclick="printLetter()">Print</button>
        </div>
        <div class="card-body">
            <textarea id="letterBody">{!! $content !!}</textarea>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('letterBody');

    function printLetter() {
        var content = CKEDITOR.instances.letterBody.getData();
        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Print Letter</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('</head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endsection
