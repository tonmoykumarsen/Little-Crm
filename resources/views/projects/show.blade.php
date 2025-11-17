@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $project->name }}</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Project Details</h5>
                <p><strong>Description:</strong> {{ $project->description }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </p>
                <p><strong>Deadline:</strong> {{ $project->deadline->format('M d, Y') }}</p>
                <p><strong>Created by:</strong> {{ $project->creator->name }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Assigned Staff</h5>
                <ul class="list-group">
                    @foreach($project->staff as $staff)
                    <li class="list-group-item">{{ $staff->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Project Tasks</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($project->tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->assignedTo->name }}</td>
                        <td>
                            <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->due_date->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection