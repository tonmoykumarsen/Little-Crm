@extends('layouts.app')

@section('title', 'Create Notice')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Notice</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('notices.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" id="priority" name="priority" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date (Optional)</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
                <div class="form-text">Leave empty if the notice has no expiry.</div>
            </div>
            <button type="submit" class="btn btn-primary">Create Notice</button>
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