@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Edit Staff: {{ $staff->name }}</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('staff.update', $staff) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ $staff->name }}" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control shadow-sm" id="email" name="email" value="{{ $staff->email }}" placeholder="Enter email address" required>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input shadow-sm" type="checkbox" id="is_active" name="is_active" value="1" {{ $staff->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">
                        Active Staff Member
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="fas fa-save me-1"></i> Update Staff
                </button>
                <a href="{{ route('staff.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
