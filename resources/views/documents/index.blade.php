@extends('layouts.master')

@section('title', 'Employee Documents')

@section('content')
    <div class="container">
        <h2>Employee Documents</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Document Title</th>
                    <th>PDF</th>
                    <th>Created By</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                    <tr>
                        <td>{{ $doc->employee->full_name }}</td>
                        <td>{{ $doc->document_title }}</td>
                        <td><a href="{{ asset('storage/'.$doc->pdf_path) }}" target="_blank">Download</a></td>
                        <td>{{ optional($doc->creator)->name }}</td>
                        <td>{{ $doc->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
