@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Staff Management</h1>
    <a href="{{ route('staff.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus me-1"></i> Add Staff
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($staff as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('staff.show', $user) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.edit', $user) }}" class="btn btn-sm btn-warning shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" 
                                        onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-users fs-3 d-block mb-2"></i>
                                No staff members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
