@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Create New Task</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="project_id" class="form-label fw-semibold">Project</label>
                <select class="form-select" id="project_id" name="project_id" required>
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="assigned_to" class="form-label fw-semibold">Assign To</label>
                <select class="form-select" id="assigned_to" name="assigned_to" required>
                    <option value="">Select Staff</option>
                    @foreach($staff as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label fw-semibold">Priority</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="1">1 Star (Lowest)</option>
                    <option value="2">2 Stars</option>
                    <option value="3" selected>3 Stars (Medium)</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars (Highest)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label fw-semibold">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-check me-1"></i> Create Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary px-4">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
