<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Asset;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function dashboard()
    {
        $data = [
            'total_staff' => User::where('role', 'staff')->count(),
            'active_projects' => Project::where('status', 'in_progress')->count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'present_today' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'pending_leaves' => Leave::where('status', 'pending')->count(),
            'assigned_assets' => Asset::where('status', 'assigned')->count(),
        ];

        return view('reports.dashboard', compact('data'));
    }

    /**
     * Attendance Report
     */
    public function attendanceReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $userId = $request->get('user_id');

        $query = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate]);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $attendances = $query->get();
        $staff = User::where('role', 'staff')->get();

        // Calculate summary
        $summary = [
            'total_days' => $attendances->count(),
            'present_days' => $attendances->where('status', 'present')->count(),
            'absent_days' => $attendances->where('status', 'absent')->count(),
            'late_days' => $attendances->where('status', 'late')->count(),
            'half_days' => $attendances->where('status', 'half_day')->count(),
        ];

        return view('reports.attendance', compact('attendances', 'staff', 'startDate', 'endDate', 'summary'));
    }

    /**
     * Leave Report
     */
    public function leaveReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfYear()->format('Y-m-d'));
        $status = $request->get('status');

        $query = Leave::with(['user', 'approvedBy'])
            ->whereBetween('start_date', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        $leaves = $query->get();
        $staff = User::where('role', 'staff')->get();

        // Calculate summary
        $summary = [
            'total_leaves' => $leaves->count(),
            'approved_leaves' => $leaves->where('status', 'approved')->count(),
            'pending_leaves' => $leaves->where('status', 'pending')->count(),
            'rejected_leaves' => $leaves->where('status', 'rejected')->count(),
            'total_days' => $leaves->sum('total_days'),
        ];

        return view('reports.leaves', compact('leaves', 'staff', 'startDate', 'endDate', 'summary'));
    }

    /**
     * Project Report
     */
    public function projectReport()
    {
        $projects = Project::with(['creator', 'staff', 'tasks'])
            ->withCount(['tasks as completed_tasks' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['tasks as total_tasks'])
            ->get()
            ->map(function($project) {
                $project->completion_rate = $project->total_tasks > 0 
                    ? round(($project->completed_tasks / $project->total_tasks) * 100, 2)
                    : 0;
                return $project;
            });

        $summary = [
            'total_projects' => $projects->count(),
            'completed_projects' => $projects->where('status', 'completed')->count(),
            'in_progress_projects' => $projects->where('status', 'in_progress')->count(),
            'pending_projects' => $projects->where('status', 'pending')->count(),
        ];

        return view('reports.projects', compact('projects', 'summary'));
    }

    /**
     * Staff Performance Report
     */
    public function staffReport(Request $request)
    {
        $staff = User::where('role', 'staff')
            ->withCount(['tasks as completed_tasks' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['tasks as total_tasks'])
            ->with(['attendances' => function($query) use ($request) {
                $month = $request->get('month', now()->month);
                $year = $request->get('year', now()->year);
                $query->whereYear('date', $year)
                      ->whereMonth('date', $month);
            }])
            ->get()
            ->map(function($user) {
                $user->completion_rate = $user->total_tasks > 0 
                    ? round(($user->completed_tasks / $user->total_tasks) * 100, 2)
                    : 0;
                    
                $user->attendance_rate = $user->attendances->count() > 0 
                    ? round(($user->attendances->where('status', 'present')->count() / $user->attendances->count()) * 100, 2)
                    : 0;
                    
                return $user;
            });

        return view('reports.staff', compact('staff'));
    }

    /**
     * Task Performance Report
     */
    public function taskReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $tasks = Task::with(['project', 'assignedTo'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $stats = [
            'total' => Task::count(),
            'completed' => Task::where('status', 'completed')->count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completion_rate' => Task::count() > 0 ? round((Task::where('status', 'completed')->count() / Task::count()) * 100, 2) : 0,
        ];

        // Group by status for chart data
        $tasksByStatus = $tasks->groupBy('status')->map->count();

        return view('reports.tasks', compact('tasks', 'stats', 'startDate', 'endDate', 'tasksByStatus'));
    }

    /**
     * Get Staff Performance Data (API)
     */
    public function getStaffPerformance()
    {
        $staff = User::where('role', 'staff')
            ->withCount(['tasks as completed_tasks', 'tasks as total_tasks'])
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'completed_tasks' => $user->completed_tasks,
                    'total_tasks' => $user->total_tasks,
                    'completion_rate' => $user->total_tasks > 0 
                        ? round(($user->completed_tasks / $user->total_tasks) * 100, 2)
                        : 0
                ];
            });

        return response()->json($staff);
    }

    /**
     * Export Report to PDF
     */
    public function exportPDF($reportType)
    {
        // This would generate PDF reports
        // You can implement PDF generation using DomPDF or similar
        return response()->json(['message' => 'PDF export feature to be implemented']);
    }

    /**
     * Export Report to Excel
     */
    public function exportExcel($reportType)
    {
        // This would generate Excel reports
        // You can implement Excel generation using Maatwebsite/Laravel-Excel
        return response()->json(['message' => 'Excel export feature to be implemented']);
    }
}