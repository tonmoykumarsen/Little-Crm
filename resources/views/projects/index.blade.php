@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>
                            <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>{{ $project->deadline ? $project->deadline->format('M d, Y') : 'No deadline' }}</td>
                        <td>{{ $project->creator->name ?? 'Unknown' }}</td>
                        <td>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No projects found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection