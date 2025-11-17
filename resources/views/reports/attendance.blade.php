@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Attendance Report</h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.attendance') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label for="user_id" class="form-label">Staff Member</label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">All Staff</option>
                        @foreach($staff as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                        <a href="{{ route('reports.attendance') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h4>{{ $summary['total_days'] }}</h4>
                <p>Total Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $summary['present_days'] }}</h4>
                <p>Present Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h4>{{ $summary['absent_days'] }}</h4>
                <p>Absent Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $summary['late_days'] }}</h4>
                <p>Late Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h4>{{ $summary['half_days'] }}</h4>
                <p>Half Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h4>{{ $summary['total_days'] > 0 ? round(($summary['present_days'] / $summary['total_days']) * 100, 2) : 0 }}%</h4>
                <p>Attendance Rate</p>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Report -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Staff</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                        <td>{{ $attendance->user->name }}</td>
                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}</td>
                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : ($attendance->status === 'late' ? 'warning' : 'info')) }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ $attendance->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No attendance records found for the selected period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection