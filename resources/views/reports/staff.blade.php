@extends('layouts.app')

@section('title', 'Staff Performance Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Performance Report</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Total Tasks</th>
                        <th>Completed Tasks</th>
                        <th>Completion Rate</th>
                        <th>Attendance Rate</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->total_tasks }}</td>
                        <td>{{ $user->completed_tasks }}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $user->completion_rate >= 80 ? 'success' : ($user->completion_rate >= 50 ? 'warning' : 'danger') }}" 
                                     style="width: {{ $user->completion_rate }}%">
                                    {{ $user->completion_rate }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $user->attendance_rate >= 90 ? 'success' : ($user->attendance_rate >= 75 ? 'warning' : 'danger') }}" 
                                     style="width: {{ $user->attendance_rate }}%">
                                    {{ $user->attendance_rate }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $performance = ($user->completion_rate + $user->attendance_rate) / 2;
                            @endphp
                            <span class="badge bg-{{ $performance >= 80 ? 'success' : ($performance >= 60 ? 'warning' : 'danger') }}">
                                {{ round($performance, 1) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No staff performance data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection