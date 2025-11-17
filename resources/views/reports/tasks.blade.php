@extends('layouts.app')

@section('title', 'Task Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Task Report</h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.tasks') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                        <a href="{{ route('reports.tasks') }}" class="btn btn-secondary">Reset</a>
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
                <h4>{{ $stats['total'] }}</h4>
                <p>Total Tasks</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $stats['completed'] }}</h4>
                <p>Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $stats['in_progress'] }}</h4>
                <p>In Progress</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h4>{{ $stats['pending'] }}</h4>
                <p>Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h4>{{ $stats['completion_rate'] }}%</h4>
                <p>Completion Rate</p>
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
                        <th>Task Title</th>
                        <th>Project</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name ?? 'No Project' }}</td>
                        <td>{{ $task->assignedTo->name ?? 'Unassigned' }}</td>
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
                        <td>{{ $task->due_date->format('M d, Y') }}</td>
                        <td>{{ $task->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No tasks found for the selected period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection