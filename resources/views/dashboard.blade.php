@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center py-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-muted mb-0">Here's what's happening with your projects today.</p>
        </div>
        <div class="text-end">
            <small class="text-muted">{{ now()->format('l, F j, Y') }}</small>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        @if(auth()->user()->role === 'admin')
        <!-- Admin Dashboard Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-primary text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['total_projects'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Projects</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-project-diagram fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $data['active_projects'] ?? 0 }} active
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-success text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['total_staff'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Team Members</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-user-check me-1"></i>
                            All active
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-warning text-dark shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['pending_tasks'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Pending Tasks</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-clock me-1"></i>
                            Needs attention
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-info text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['active_tasks'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">In Progress</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-spinner fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-play-circle me-1"></i>
                            Currently working
                        </small>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- Staff Dashboard Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-primary text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['my_projects'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">My Projects</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-project-diagram fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-chart-line me-1"></i>
                            Active assignments
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-success text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['my_tasks'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Tasks</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-list-alt me-1"></i>
                            All assignments
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-warning text-dark shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['pending_tasks'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Pending Tasks</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Requires action
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-info text-white shadow-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $data['completed_tasks'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Completed</p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="fas fa-trophy me-1"></i>
                            Great work!
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        @if(auth()->user()->role === 'admin')
        <!-- Admin Dashboard Content -->
        <div class="col-xl-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-rocket me-2 text-primary"></i>
                            Recent Projects
                        </h5>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($data['recent_projects']) && $data['recent_projects']->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($data['recent_projects'] as $project)
                        <div class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $project->name }}</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $project->creator->name ?? 'Unknown' }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-calendar me-1"></i>
                                        Deadline: {{ $project->deadline ? $project->deadline->format('M d, Y') : 'Not set' }}
                                    </p>
                                </div>
                                <span class="badge status-badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <hr class="my-2">
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No projects created yet</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm mt-2">Create First Project</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-check me-2 text-success"></i>
                            Recent Tasks
                        </h5>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-success">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($data['recent_tasks']) && $data['recent_tasks']->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($data['recent_tasks'] as $task)
                        <div class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $task->title }}</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-project-diagram me-1"></i>
                                        {{ $task->project->name ?? 'No Project' }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $task->assignedTo->name ?? 'Unassigned' }}
                                        • Due: {{ $task->due_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="badge status-badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <hr class="my-2">
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No tasks created yet</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm mt-2">Create First Task</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @else
        <!-- Staff Dashboard Content -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-check me-2 text-primary"></i>
                            My Recent Tasks
                        </h5>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($data['my_recent_tasks']) && $data['my_recent_tasks']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Task</th>
                                    <th>Project</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['my_recent_tasks'] as $task)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $task->title }}</h6>
                                            <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $task->project->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'danger' : 'dark' }}">
                                            {{ $task->due_date->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $task->priority ? ' text-warning' : ' text-muted' }}"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        <span class="badge status-badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info" title="View Task">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning" title="Edit Task">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
                                                <button type="submit" class="btn btn-outline-success" title="Start Time Tracking">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('time-logs.end') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" title="Stop Time Tracking">
                                                    <i class="fas fa-stop"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tasks assigned</h5>
                        <p class="text-muted mb-3">You don't have any tasks assigned to you yet.</p>
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Browse Available Tasks</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    @if(auth()->user()->role === 'staff')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
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

                    <div class="row g-3">
                        <div class="col-md-3">
                            <form action="{{ route('attendance.checkin') }}" method="POST" class="h-100">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 h-100 py-3">
                                    <i class="fas fa-sign-in-alt fa-2x mb-2"></i><br>
                                    Check In
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('attendance.checkout') }}" method="POST" class="h-100">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 h-100 py-3">
                                    <i class="fas fa-sign-out-alt fa-2x mb-2"></i><br>
                                    Check Out
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('leaves.create') }}" class="btn btn-info w-100 h-100 py-3">
                                <i class="fas fa-umbrella-beach fa-2x mb-2"></i><br>
                                Apply Leave
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('time-logs.index') }}" class="btn btn-primary w-100 h-100 py-3">
                                <i class="fas fa-clock fa-2x mb-2"></i><br>
                                Time Logs
                            </a>
                        </div>
                    </div>

                    <!-- Current Attendance Status -->
                    @php
                        $todayAttendance = \App\Models\Attendance::where('user_id', auth()->id())
                            ->whereDate('date', today())
                            ->first();
                    @endphp
                    
                    @if($todayAttendance)
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="mb-2">Today's Attendance Status</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Check In:</small>
                                <div class="fw-semibold">
                                    {{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : 'Not checked in' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Check Out:</small>
                                <div class="fw-semibold">
                                    {{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : 'Not checked out' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Status:</small>
                                <div>
                                    <span class="badge bg-{{ $todayAttendance->status === 'present' ? 'success' : ($todayAttendance->status === 'absent' ? 'danger' : ($todayAttendance->status === 'late' ? 'warning' : 'info')) }}">
                                        {{ ucfirst($todayAttendance->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.stats-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: none;
    border-radius: 12px;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.shadow-hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.shadow-hover:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-warning .icon-circle {
    background: rgba(0, 0, 0, 0.1);
}

.status-badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
    border-radius: 6px;
}

.card {
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.card-header {
    padding: 1.25rem 1.5rem 0.5rem;
}

.card-title {
    font-weight: 600;
}

.list-group-item {
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 6px;
}
</style>
@endsection