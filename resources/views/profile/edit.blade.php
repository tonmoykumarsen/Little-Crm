@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold">My Profile</h2>
</div>

<div class="row g-4">
    
    <!-- Profile Info -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Profile Information</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="name" 
                               name="name" 
                               value="{{ auth()->user()->name }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" 
                               class="form-control form-control-lg" 
                               id="email" 
                               name="email" 
                               value="{{ auth()->user()->email }}" 
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg mt-2 px-4">
                        <i class="fas fa-save me-1"></i> Update Profile
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-bold mb-0"><i class="fas fa-lock me-2 text-warning"></i> Change Password</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Current Password</label>
                        <input type="password" 
                               class="form-control form-control-lg" 
                               id="current_password" 
                               name="current_password">
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">New Password</label>
                        <input type="password" 
                               class="form-control form-control-lg" 
                               id="new_password" 
                               name="new_password">
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" 
                               class="form-control form-control-lg" 
                               id="new_password_confirmation" 
                               name="new_password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg mt-2 px-4">
                        <i class="fas fa-key me-1"></i> Change Password
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>

@endsection
