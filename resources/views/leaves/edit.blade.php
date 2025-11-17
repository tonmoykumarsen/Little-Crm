@extends('layouts.app')

@section('title', 'Edit Leave Application')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Leave Application</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('leaves.update', $leave) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="type" class="form-label">Leave Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="sick" {{ $leave->type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                    <option value="casual" {{ $leave->type == 'casual' ? 'selected' : '' }}>Casual Leave</option>
                    <option value="annual" {{ $leave->type == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                    <option value="emergency" {{ $leave->type == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                    <option value="maternity" {{ $leave->type == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                    <option value="paternity" {{ $leave->type == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $leave->start_date->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $leave->end_date->format('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" required>{{ $leave->reason }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Application</button>
            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    // Update end date min when start date changes
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
    });
});
</script>
@endsection