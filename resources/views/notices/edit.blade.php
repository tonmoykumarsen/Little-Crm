@extends('layouts.app')

@section('title', 'Edit Notice')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Notice</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('notices.update', $notice) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $notice->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="8" required>{{ old('description', $notice->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" id="priority" name="priority" required>
                            <option value="low" {{ $notice->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $notice->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $notice->priority == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ $notice->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $notice->start_date->format('Y-m-d')) }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date (Optional)</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $notice->end_date ? $notice->end_date->format('Y-m-d') : '') }}">
                        <div class="form-text">Leave empty if the notice has no expiry.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $notice->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active Notice</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Notice</button>
            <a href="{{ route('notices.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDate.min = today;
    
    // Update end date min when start date changes
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
    });
});
</script>
@endsection