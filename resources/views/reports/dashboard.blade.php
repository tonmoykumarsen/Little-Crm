@extends('layouts.app')

@section('title', 'Reports Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reports Dashboard</h1>
</div>

<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h4>{{ $data['total_staff'] }}</h4>
                <p>Total Staff</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $data['active_projects'] }}</h4>
                <p>Active Projects</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $data['pending_tasks'] }}</h4>
                <p>Pending Tasks</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h4>{{ $data['present_today'] }}</h4>
                <p>Present Today</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h4>{{ $data['pending_leaves'] }}</h4>
                <p>Pending Leaves</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-dark">
            <div class="card-body text-center">
                <h4>{{ $data['assigned_assets'] }}</h4>
                <p>Assigned Assets</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Reports</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('reports.attendance') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i>Attendance Report
                    </a>
                    <a href="{{ route('reports.leaves') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-umbrella-beach me-2"></i>Leave Report
                    </a>
                    <a href="{{ route('reports.projects') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-project-diagram me-2"></i>Project Report
                    </a>
                    <a href="{{ route('reports.staff') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>Staff Performance
                    </a>
                    <a href="{{ route('reports.tasks') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tasks me-2"></i>Task Report
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Recent Activities</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Recent system activities will be displayed here.</p>
                <!-- You can add recent activities, charts, or graphs here -->
            </div>
        </div>
    </div>
</div>
@endsection