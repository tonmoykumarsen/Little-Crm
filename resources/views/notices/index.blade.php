@extends('layouts.app')

@section('title', 'Notices')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        @if(auth()->user()->role === 'admin')
            All Notices
        @else
            Company Notices
        @endif
    </h1>
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('notices.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Create Notice
    </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @if(auth()->user()->role === 'admin')
        <!-- Admin View - All Notices -->
        @forelse($notices as $notice)
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : 'primary') }}">
                <div class="card-header d-flex justify-content-between align-items-center bg-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : ($notice->priority === 'medium' ? 'info' : 'secondary') }} text-white">
                    <h5 class="card-title mb-0">{{ Str::limit($notice->title, 50) }}</h5>
                    <div>
                        <span class="badge bg-light text-dark me-1">
                            {{ ucfirst($notice->priority) }}
                        </span>
                        <span class="badge bg-{{ $notice->is_active ? 'success' : 'danger' }}">
                            {{ $notice->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ Str::limit($notice->description, 150) }}</p>
                    <div class="d-flex justify-content-between text-muted small">
                        <div>
                            <i class="fas fa-user me-1"></i>{{ $notice->creator->name }}
                        </div>
                        <div>
                            <i class="fas fa-calendar me-1"></i>{{ $notice->start_date->format('M d') }}
                            @if($notice->end_date)
                            - {{ $notice->end_date->format('M d') }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('notices.show', $notice) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        <div>
                            <a href="{{ route('notices.edit', $notice) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('notices.destroy', $notice) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No notices found</h5>
                <p class="text-muted mb-3">Create your first notice to keep your team informed.</p>
                <a href="{{ route('notices.create') }}" class="btn btn-primary">Create First Notice</a>
            </div>
        </div>
        @endforelse
    @else
        <!-- Staff View - Active Notices Only -->
        @forelse($notices as $notice)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : 'primary') }}">
                <div class="card-header d-flex justify-content-between align-items-center bg-{{ $notice->priority === 'urgent' ? 'danger' : ($notice->priority === 'high' ? 'warning' : ($notice->priority === 'medium' ? 'info' : 'secondary') }} text-white">
                    <h5 class="card-title mb-0">{{ Str::limit($notice->title, 50) }}</h5>
                    <span class="badge bg-light text-dark">
                        {{ ucfirst($notice->priority) }} Priority
                    </span>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ Str::limit($notice->description, 200) }}</p>
                    <div class="d-flex justify-content-between text-muted small mt-3">
                        <div>
                            <i class="fas fa-user me-1"></i>By: {{ $notice->creator->name }}
                        </div>
                        <div>
                            <i class="fas fa-clock me-1"></i>{{ $notice->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('notices.show', $notice) }}" class="btn btn-sm btn-primary w-100">
                        Read Full Notice
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No active notices</h5>
                <p class="text-muted">There are no current notices at this time.</p>
            </div>
        </div>
        @endforelse
    @endif
</div>

@if(auth()->user()->role === 'admin' && $notices->count() > 0)
<div class="mt-4">
    <div class="card">
        <div class="card-body">
            <h6>Notice Statistics</h6>
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="text-primary">
                        <h4>{{ $notices->count() }}</h4>
                        <small>Total Notices</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-success">
                        <h4>{{ $notices->where('is_active', true)->count() }}</h4>
                        <small>Active Notices</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-warning">
                        <h4>{{ $notices->where('priority', 'high')->count() }}</h4>
                        <small>High Priority</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-danger">
                        <h4>{{ $notices->where('priority', 'urgent')->count() }}</h4>
                        <small>Urgent</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection