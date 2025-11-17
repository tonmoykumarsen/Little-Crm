@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Project</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Assign Staff</label>
                <div>
                    @foreach($staff as $user)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="staff[]" value="{{ $user->id }}" id="staff{{ $user->id }}">
                        <label class="form-check-label" for="staff{{ $user->id }}">
                            {{ $user->name }} ({{ $user->email }})
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Project</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection