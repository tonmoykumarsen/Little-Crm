@extends('layouts.app')

@section('title', $staff->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Staff Details: {{ $staff->name }}</h1>
    <div>
        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning shadow-sm">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('staff.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- Staff Information -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Staff Information</h5>
                <p><strong>Name:</strong> {{ $staff->name }}</p>
                <p><strong>Email:</strong> {{ $staff->email }}</p>
                <p><strong>Role:</strong> 
                    <span class="badge bg-info text-dark">{{ ucfirst($staff->role) }}</span>
                </p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }}">
                        {{ $staff->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
                <p><strong>Member Since:</strong> {{ $staff->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Assigned Projects -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Assigned Projects</h5>
                @if($staff->projects->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($staff->projects as $project)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $project->name }}</span>
                                <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No projects assigned.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Assigned Tasks -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-3">Assigned Tasks</h5>
        @if($staff->tasks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Task</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff->tasks as $task)
                            <tr>
                                <td class="fw-medium">{{ $task->title }}</td>
                                <td>{{ $task->project->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $task->priority ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td>{{ $task->due_date->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No tasks assigned.</p>
        @endif
    </div>
</div>
@endsection
