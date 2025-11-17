<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $leaves = Leave::with(['user', 'approvedBy'])->latest()->paginate(10);
        } else {
            $leaves = $user->leaves()->with(['user', 'approvedBy'])->latest()->paginate(10);
        }
        
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        // Only staff can apply for leave
        if (auth()->user()->role !== 'staff') {
            abort(403, 'Only staff members can apply for leave.');
        }
        
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        // Only staff can apply for leave
        if (auth()->user()->role !== 'staff') {
            abort(403, 'Only staff members can apply for leave.');
        }

        $request->validate([
            'type' => 'required|in:sick,casual,annual,emergency,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $totalDays = $start->diffInDays($end) + 1;

        // Check if the leave dates overlap with existing approved leaves
        $existingLeave = Leave::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function($q) use ($start, $end) {
                          $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                      });
            })
            ->exists();

        if ($existingLeave) {
            return back()->with('error', 'You already have approved leave during this period.');
        }

        Leave::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave application submitted successfully. It will be reviewed by admin.');
    }

    public function show(Leave $leave)
    {
        // Staff can only view their own leaves, admin can view all
        if (auth()->user()->role === 'staff' && $leave->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        // Staff can only edit their own pending leaves, admin can edit all
        if (auth()->user()->role === 'staff') {
            if ($leave->user_id !== auth()->id() || $leave->status !== 'pending') {
                abort(403, 'You can only edit your pending leave applications.');
            }
        }

        return view('leaves.edit', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        // Staff can only update their own pending leaves
        if (auth()->user()->role === 'staff') {
            if ($leave->user_id !== auth()->id() || $leave->status !== 'pending') {
                abort(403, 'You can only edit your pending leave applications.');
            }
        }

        $request->validate([
            'type' => 'required|in:sick,casual,annual,emergency,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $totalDays = $start->diffInDays($end) + 1;

        $leave->update([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave application updated successfully.');
    }

    public function approve(Leave $leave)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admin can approve leaves.');
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Leave application approved successfully.');
    }

    public function reject(Request $request, Leave $leave)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admin can reject leaves.');
        }

        $request->validate([
            'admin_notes' => 'required|string|min:10',
        ]);

        $leave->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Leave application rejected.');
    }
}