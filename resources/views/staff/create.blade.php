@extends('layouts.app')

@section('title', 'Add Staff')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Add New Staff</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" class="form-control shadow-sm" id="name" name="name" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control shadow-sm" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" class="form-control shadow-sm" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="fas fa-user-plus me-1"></i> Create Staff
                </button>
                <a href="{{ route('staff.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
