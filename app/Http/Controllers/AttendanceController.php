<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $attendances = Attendance::with('user')->latest()->paginate(20);
            $staff = User::where('role', 'staff')->active()->get();
            return view('attendances.index', compact('attendances', 'staff'));
        } else {
            $attendances = $user->attendances()->latest()->paginate(20);
            return view('attendances.index', compact('attendances'));
        }
    }

    public function create()
    {
        $staff = User::where('role', 'staff')->active()->get();
        return view('attendances.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,half_day',
            'notes' => 'nullable|string',
        ]);

        // Check if attendance already exists for this user and date
        $existing = Attendance::where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Attendance already recorded for this date.');
        }

        Attendance::create($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }

    public function checkIn(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Check if already checked in today
        $existing = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            if ($existing->check_in) {
                return redirect()->route('dashboard')->with('error', 'You have already checked in today.');
            }
            // Update existing record
            $existing->update([
                'check_in' => Carbon::now(),
                'status' => 'present'
            ]);
        } else {
            // Create new attendance record
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_in' => Carbon::now(),
                'status' => 'present',
                'notes' => 'Auto-checked in'
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Checked in successfully at ' . Carbon::now()->format('h:i A'));
    }

    public function checkOut(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->route('dashboard')->with('error', 'No check-in found for today. Please check in first.');
        }

        if ($attendance->check_out) {
            return redirect()->route('dashboard')->with('error', 'You have already checked out today.');
        }

        $attendance->update([
            'check_out' => Carbon::now(),
            'notes' => $attendance->notes ? $attendance->notes . ' | Auto-checked out' : 'Auto-checked out'
        ]);

        return redirect()->route('dashboard')->with('success', 'Checked out successfully at ' . Carbon::now()->format('h:i A'));
    }

    // Add other methods: show, edit, update, destroy as needed
    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $staff = User::where('role', 'staff')->active()->get();
        return view('attendances.edit', compact('attendance', 'staff'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,half_day',
            'notes' => 'nullable|string',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance record deleted successfully.');
    }
}