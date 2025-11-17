@extends('layouts.app')

@section('title', 'Project Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Project Report</h1>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h4>{{ $summary['total_projects'] }}</h4>
                <p>Total Projects</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $summary['completed_projects'] }}</h4>
                <p>Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $summary['in_progress_projects'] }}</h4>
                <p>In Progress</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h4>{{ $summary['pending_projects'] }}</h4>
                <p>Pending</p>
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
                        <th>Project Name</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Total Tasks</th>
                        <th>Completed Tasks</th>
                        <th>Completion Rate</th>
                        <th>Assigned Staff</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>
                            <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>{{ $project->creator->name ?? 'Unknown' }}</td>
                        <td>{{ $project->total_tasks }}</td>
                        <td>{{ $project->completed_tasks }}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $project->completion_rate >= 80 ? 'success' : ($project->completion_rate >= 50 ? 'warning' : 'danger') }}" 
                                     style="width: {{ $project->completion_rate }}%">
                                    {{ $project->completion_rate }}%
                                </div>
                            </div>
                        </td>
                        <td>{{ $project->staff->count() }} staff</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No projects found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection