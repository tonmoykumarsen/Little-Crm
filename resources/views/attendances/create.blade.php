@extends('layouts.app')

@section('title', 'Add Attendance')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Attendance Record</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Staff Member</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">Select Staff</option>
                    @foreach($staff as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="check_in" class="form-label">Check In Time</label>
                        <input type="time" class="form-control" id="check_in" name="check_in" value="{{ old('check_in') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="check_out" class="form-label">Check Out Time</label>
                        <input type="time" class="form-control" id="check_out" name="check_out" value="{{ old('check_out') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                    <option value="half_day">Half Day</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Attendance</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection