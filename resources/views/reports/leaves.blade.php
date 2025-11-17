@extends('layouts.app')

@section('title', 'Leave Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Leave Report</h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.leaves') }}">
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
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                        <a href="{{ route('reports.leaves') }}" class="btn btn-secondary">Reset</a>
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
                <h4>{{ $summary['total_leaves'] }}</h4>
                <p>Total Leaves</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $summary['approved_leaves'] }}</h4>
                <p>Approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $summary['pending_leaves'] }}</h4>
                <p>Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h4>{{ $summary['rejected_leaves'] }}</h4>
                <p>Rejected</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h4>{{ $summary['total_days'] }}</h4>
                <p>Total Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h4>{{ $summary['total_leaves'] > 0 ? round(($summary['approved_leaves'] / $summary['total_leaves']) * 100, 2) : 0 }}%</h4>
                <p>Approval Rate</p>
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
                        <th>Staff</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Days</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Approved By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td>{{ $leave->user->name }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($leave->type) }}</span>
                        </td>
                        <td>{{ $leave->start_date->format('M d, Y') }}</td>
                        <td>{{ $leave->end_date->format('M d, Y') }}</td>
                        <td>{{ $leave->total_days }} days</td>
                        <td>{{ Str::limit($leave->reason, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $leave->status === 'approved' ? 'success' : ($leave->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td>{{ $leave->approvedBy->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No leave records found for the selected period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection