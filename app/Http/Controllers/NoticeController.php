<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use Carbon\Carbon;

class NoticeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Admin sees all notices
            $notices = Notice::with('creator')->latest()->get();
        } else {
            // Staff sees only active notices within date range
            $notices = Notice::with('creator')
                ->where('is_active', true)
                ->where('start_date', '<=', Carbon::now())
                ->where(function($query) {
                    $query->where('end_date', '>=', Carbon::now())
                          ->orWhereNull('end_date');
                })
                ->latest()
                ->get();
        }

        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        // Only admin can create notices
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can create notices.');
        }
        
        return view('notices.create');
    }

    public function store(Request $request)
    {
        // Only admin can create notices
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can create notices.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        Notice::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->id(),
            'is_active' => true,
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice created successfully.');
    }

    public function show(Notice $notice)
    {
        // Staff can only view active notices within date range
        if (auth()->user()->role === 'staff') {
            if (!$notice->is_active || 
                $notice->start_date > Carbon::now() || 
                ($notice->end_date && $notice->end_date < Carbon::now())) {
                abort(404, 'Notice not found or no longer available.');
            }
        }

        return view('notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        // Only admin can edit notices
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can edit notices.');
        }

        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        // Only admin can update notices
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can update notices.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $notice->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? $notice->is_active,
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        // Only admin can delete notices
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can delete notices.');
        }

        $notice->delete();

        return redirect()->route('notices.index')->with('success', 'Notice deleted successfully.');
    }

    public function toggleStatus(Notice $notice)
    {
        // Only admin can toggle notice status
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can change notice status.');
        }

        $notice->update([
            'is_active' => !$notice->is_active
        ]);

        $status = $notice->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Notice {$status} successfully.");
    }
}