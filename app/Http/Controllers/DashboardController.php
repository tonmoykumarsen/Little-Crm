<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\TimeLog;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Admin Dashboard Data
            $data = [
                'total_projects' => Project::count(),
                'total_staff' => User::where('role', 'staff')->count(),
                'pending_tasks' => Task::where('status', 'pending')->count(),
                'active_tasks' => Task::where('status', 'in_progress')->count(),
                'recent_projects' => Project::with('creator')->latest()->take(5)->get(),
                'recent_tasks' => Task::with(['project', 'assignedTo'])->latest()->take(5)->get(),
            ];
        } else {
            // Staff Dashboard Data
            $data = [
                'my_projects' => $user->projects()->count(),
                'my_tasks' => $user->tasks()->count(),
                'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
                'completed_tasks' => $user->tasks()->where('status', 'completed')->count(),
                'active_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
                'my_recent_tasks' => $user->tasks()->with('project')->latest()->take(5)->get(),
                'active_time_logs' => $user->timeLogs()->whereNull('end_time')->get(),
            ];
        }
        
        return view('dashboard', compact('data'));
    }
}