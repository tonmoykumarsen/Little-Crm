<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $tasks = Task::with(['project', 'assignedTo', 'creator'])->latest()->paginate(10);
        } else {
            $tasks = $user->tasks()->with(['project', 'assignedTo', 'creator'])->latest()->paginate(10);
        }
        
        return view('tasks.index', compact('tasks'));
    }

    // Only admin can create tasks
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $projects = Project::all();
        $staff = User::where('role', 'staff')->active()->get();
        
        return view('tasks.create', compact('projects', 'staff'));
    }

    // Only admin can store tasks
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|integer|min:1|max:5',
            'due_date' => 'required|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        // Check if staff user is assigned to this task
        if (auth()->user()->role === 'staff' && $task->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->load(['project', 'assignedTo', 'creator', 'timeLogs.user']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // Staff can only edit their own tasks, admin can edit all
        if (auth()->user()->role === 'staff' && $task->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $projects = Project::all();
        $staff = User::where('role', 'staff')->active()->get();
        return view('tasks.edit', compact('task', 'projects', 'staff'));
    }

    public function update(Request $request, Task $task)
    {
        // Staff can only update their own tasks, admin can update all
        if (auth()->user()->role === 'staff' && $task->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|integer|min:1|max:5',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Update task status (for staff)
     */
    public function updateStatus(Request $request, Task $task)
    {
        if (auth()->user()->role === 'staff' && $task->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated successfully.');
    }
}