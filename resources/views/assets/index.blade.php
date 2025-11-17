@extends('layouts.app')

@section('title', 'Asset Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Asset Management</h1>
    <a href="{{ route('assets.create') }}" class="btn btn-primary">Add Asset</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->serial_number }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($asset->category) }}</span>
                        </td>
                        <td>{{ $asset->purchase_price ? '$' . number_format($asset->purchase_price, 2) : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $asset->status === 'available' ? 'success' : ($asset->status === 'assigned' ? 'primary' : ($asset->status === 'maintenance' ? 'warning' : 'secondary')) }}">
                                {{ ucfirst($asset->status) }}
                            </span>
                        </td>
                        <td>{{ $asset->assignedTo->name ?? 'Not Assigned' }}</td>
                        <td>
                            @if($asset->status === 'available')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal{{ $asset->id }}">
                                Assign
                            </button>
                            @elseif($asset->status === 'assigned')
                            <form action="{{ route('assets.unassign', $asset) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">Unassign</button>
                            </form>
                            @endif
                            
                            <!-- Assign Modal -->
                            <div class="modal fade" id="assignModal{{ $asset->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign Asset: {{ $asset->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('assets.assign', $asset) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="assigned_to" class="form-label">Assign to Staff</label>
                                                    <select class="form-control" id="assigned_to" name="assigned_to" required>
                                                        <option value="">Select Staff</option>
                                                        @foreach($staff as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Assign Asset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No assets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection