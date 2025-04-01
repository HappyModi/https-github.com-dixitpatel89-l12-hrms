@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>{{ $template->name }}</h2>
        <div class="letter-body">
            {!! $letterBody !!}
        </div>
        <a href="{{ route('download.pdf', ['employeeId' => $employee->id, 'templateId' => $template->id]) }}" class="btn btn-primary">
            Download PDF
        </a>
    </div>
@endsection
