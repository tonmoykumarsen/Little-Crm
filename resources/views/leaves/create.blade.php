@extends('layouts.app')

@section('title', 'Apply for Leave')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Apply for Leave</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('leaves.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="type" class="form-label">Leave Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="sick">Sick Leave</option>
                    <option value="casual">Casual Leave</option>
                    <option value="annual">Annual Leave</option>
                    <option value="emergency">Emergency Leave</option>
                    <option value="maternity">Maternity Leave</option>
                    <option value="paternity">Paternity Leave</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Application</button>
            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Cancel</a>
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
    endDate.min = today;
    
    // Update end date min when start date changes
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
    });
});
</script>
@endsection