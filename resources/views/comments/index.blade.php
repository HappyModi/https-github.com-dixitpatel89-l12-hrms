@extends('layouts.app')

@section('content')
    <h1>Activity Log</h1>
    <table border="1">
        <tr>
            <th>User</th>
            <th>Company</th>
            <th>Employee</th>
            <th>Action</th>
            <th>Description</th>
            <th>Changes</th>
            <th>Date</th>
        </tr>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->user->name }}</td>
                <td>{{ $comment->company->company_name ?? 'N/A' }}</td>
                <td>{{ $comment->employee->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($comment->action) }}</td>
                <td>{{ $comment->description }}</td>
                <td>
                    @if($comment->changes)
                        @foreach(json_decode($comment->changes, true) as $field => $oldValue)
                            <strong>{{ $field }}:</strong> {{ $oldValue }} → {{ $comment->employee->$field ?? 'N/A' }} <br>
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $comment->created_at }}</td>
            </tr>
        @endforeach
    </table>
@endsection
