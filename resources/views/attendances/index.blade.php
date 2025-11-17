@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Attendance Management</h1>
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('attendances.create') }}" class="btn btn-primary">Add Attendance</a>
    @endif
</div>

@if(auth()->user()->role === 'staff')
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Today's Attendance</h5>
                <p class="card-text">{{ \Carbon\Carbon::today()->format('M d, Y') }}</p>
                <form action="{{ route('attendance.checkin') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">Check In</button>
                </form>
                <form action="{{ route('attendance.checkout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-lg">Check Out</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Staff</th>
                        @endif
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Notes</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td>{{ $attendance->user->name }}</td>
                        @endif
                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}</td>
                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : ($attendance->status === 'late' ? 'warning' : 'info')) }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ $attendance->notes ?? '-' }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td>
                            <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '5' }}" class="text-center">No attendance records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection