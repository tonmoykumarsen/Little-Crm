<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $projects = Project::with(['creator', 'staff'])->latest()->get();
        } else {
            $projects = $user->projects()->with(['creator', 'staff'])->latest()->get();
        }
        
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        $staff = User::where('role', 'staff')->active()->get();
        return view('projects.create', compact('staff'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'staff' => 'array',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'created_by' => auth()->id(),
        ]);

        // Assign staff to project
        if ($request->has('staff')) {
            $project->staff()->attach($request->staff);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        $project->load(['creator', 'staff', 'tasks.assignedTo']);
        return view('projects.show', compact('project'));
    }

    /**
     * Assign staff to project
     */
    public function assignStaff(Request $request, Project $project)
    {
        $request->validate([
            'staff' => 'required|array',
        ]);

        $project->staff()->sync($request->staff);

        return back()->with('success', 'Staff assigned successfully.');
    }
}