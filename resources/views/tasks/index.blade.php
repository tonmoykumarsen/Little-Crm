@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        @if(auth()->user()->role === 'admin')
            All Tasks
        @else
            My Tasks
        @endif
    </h1>
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Create Task
    </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Assigned To</th>
                        @endif
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>
                            <strong>{{ $task->title }}</strong>
                            @if(auth()->user()->role === 'staff' && $task->due_date->isPast() && $task->status !== 'completed')
                            <span class="badge bg-danger ms-1">Overdue</span>
                            @endif
                        </td>
                        <td>{{ $task->project->name ?? 'No Project' }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td>{{ $task->assignedTo->name }}</td>
                        @endif
                        <td>
                            <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $task->priority ? ' text-warning' : ' text-muted' }}"></i>
                            @endfor
                        </td>
                        <td class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger' : '' }}">
                            {{ $task->due_date->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(auth()->user()->role === 'admin' || $task->assigned_to === auth()->id())
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user()->role === 'staff' && $task->assigned_to === auth()->id())
                                <!-- Time Tracking Buttons -->
                                @php
                                    $activeTimeLog = \App\Models\TimeLog::where('user_id', auth()->id())
                                        ->where('task_id', $task->id)
                                        ->whereNull('end_time')
                                        ->first();
                                @endphp
                                
                                @if(!$activeTimeLog)
                                <form action="{{ route('time-logs.start') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Start Time Tracking">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('time-logs.end') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Stop Time Tracking">
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <!-- Status Update Dropdown -->
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-flag"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                                                <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}">
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-clock text-secondary me-1"></i>Mark as Pending
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                                                <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}">
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-spinner text-warning me-1"></i>Mark as In Progress
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                                                <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}">
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-check text-success me-1"></i>Mark as Completed
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}" class="text-center py-4">
                            <i class="fas fa-tasks fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">
                                @if(auth()->user()->role === 'admin')
                                No tasks found. <a href="{{ route('tasks.create') }}">Create the first task</a>
                                @else
                                No tasks assigned to you yet.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Fixed Pagination Section -->
        @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
                </div>
                {{ $tasks->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection