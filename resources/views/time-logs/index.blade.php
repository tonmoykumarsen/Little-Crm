@extends('layouts.app')

@section('title', 'Time Logs')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
    <h1 class="h3 fw-bold mb-0">Time Logs</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($timeLogs as $log)
                        <tr>
                            <td class="fw-semibold">{{ $log->user->name }}</td>
                            <td>{{ $log->task->title }}</td>

                            <td>
                                <span class="text-primary fw-medium">
                                    {{ $log->start_time->format('M d, Y H:i') }}
                                </span>
                            </td>

                            <td>
                                @if($log->end_time)
                                    <span class="text-success fw-medium">
                                        {{ $log->end_time->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">In Progress</span>
                                @endif
                            </td>

                            <td>
                                @if($log->duration_minutes)
                                    <span class="badge bg-info">{{ $log->duration_minutes }} mins</span>
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $log->description ?? '-' }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-clock-history fs-4 d-block mb-2"></i>
                                    No time logs found.
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
