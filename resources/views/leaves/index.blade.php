@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Leave Management</h1>
    <a href="{{ route('leaves.create') }}" class="btn btn-primary">Apply for Leave</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
                        <th>Actions</th>
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
                        <td>
                            @if(auth()->user()->role === 'admin' && $leave->status === 'pending')
                            <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
                                Reject
                            </button>
                            
                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Leave Application</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('leaves.reject', $leave) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="admin_notes" class="form-label">Reason for Rejection</label>
                                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject Leave</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No leave applications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection