@extends('layouts.app')

@section('title', 'Leave Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Leave Application Details</h1>
    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Leave Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Staff Member:</strong>
                        <p>{{ $leave->user->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Leave Type:</strong>
                        <p>
                            <span class="badge bg-info">{{ ucfirst($leave->type) }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Start Date:</strong>
                        <p>{{ $leave->start_date->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>End Date:</strong>
                        <p>{{ $leave->end_date->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total Days:</strong>
                        <p>{{ $leave->total_days }} days</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            <span class="badge bg-{{ $leave->status === 'approved' ? 'success' : ($leave->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Reason:</strong>
                    <p class="border p-3 rounded bg-light">{{ $leave->reason }}</p>
                </div>
                
                @if($leave->admin_notes)
                <div class="mb-3">
                    <strong>Admin Notes:</strong>
                    <p class="border p-3 rounded bg-light">{{ $leave->admin_notes }}</p>
                </div>
                @endif
                
                @if($leave->approvedBy)
                <div class="row">
                    <div class="col-md-6">
                        <strong>Approved By:</strong>
                        <p>{{ $leave->approvedBy->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Approved At:</strong>
                        <p>{{ $leave->approved_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection