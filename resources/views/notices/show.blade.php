@extends('layouts.app')

@section('title', $notice->title)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Notice Details</h1>
    <div>
        <a href="{{ route('notices.index') }}" class="btn btn-secondary">Back to Notices</a>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('notices.edit', $notice) }}" class="btn btn-warning">Edit</a>
        @endif
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : 'primary') }}">
            <div class="card-header bg-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : ($notice->priority === 'medium' ? 'info' : 'secondary') }} text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ $notice->title }}</h4>
                    <span class="badge bg-light text-dark">
                        {{ ucfirst($notice->priority) }} Priority
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="notice-content">
                    {!! nl2br(e($notice->description)) !!}
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Posted by:</strong> {{ $notice->creator->name }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Posted on:</strong> {{ $notice->created_at->format('M d, Y h:i A') }}
                            </small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Start Date:</strong> {{ $notice->start_date->format('M d, Y') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>End Date:</strong> {{ $notice->end_date ? $notice->end_date->format('M d, Y') : 'No expiry' }}
                            </small>
                        </div>
                    </div>
                    @if(auth()->user()->role === 'admin')
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $notice->is_active ? 'success' : 'danger' }}">
                                    {{ $notice->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if(auth()->user()->role === 'admin')
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Last updated: {{ $notice->updated_at->format('M d, Y h:i A') }}
                    </small>
                    <div>
                        <form action="{{ route('notices.toggle-status', $notice) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $notice->is_active ? 'warning' : 'success' }}">
                                {{ $notice->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('notices.destroy', $notice) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notice?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.notice-content {
    font-size: 1.1em;
    line-height: 1.6;
    white-space: pre-line;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
@endsection