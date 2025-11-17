<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeLog;
use App\Models\Task;
use Carbon\Carbon;

class TimeLogController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $timeLogs = TimeLog::with(['user', 'task'])->latest()->get();
        } else {
            $timeLogs = $user->timeLogs()->with('task')->latest()->get();
        }
        
        return view('time-logs.index', compact('timeLogs'));
    }

    /**
     * Start time tracking for a task
     */
    public function start(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Check if user is assigned to this task
        $task = Task::find($request->task_id);
        if ($user->role === 'staff' && $task->assigned_to !== $user->id) {
            return back()->with('error', 'You are not assigned to this task.');
        }

        // Check if user already has an active time log
        $activeLog = TimeLog::where('user_id', $user->id)
            ->whereNull('end_time')
            ->first();

        if ($activeLog) {
            return back()->with('error', 'You already have an active time log for task: ' . $activeLog->task->title . '. Please stop it first.');
        }

        TimeLog::create([
            'user_id' => $user->id,
            'task_id' => $request->task_id,
            'start_time' => Carbon::now(),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Time tracking started for task: ' . $task->title);
    }

    /**
     * Stop time tracking
     */
    public function end(Request $request)
    {
        $user = auth()->user();

        $timeLog = TimeLog::where('user_id', $user->id)
            ->whereNull('end_time')
            ->first();

        if (!$timeLog) {
            return back()->with('error', 'No active time log found.');
        }

        $timeLog->update([
            'end_time' => Carbon::now(),
            'duration_minutes' => $timeLog->start_time->diffInMinutes(Carbon::now()),
        ]);

        return back()->with('success', 'Time tracking stopped. Duration: ' . $timeLog->duration_minutes . ' minutes.');
    }

    /**
     * Pause time tracking (optional feature)
     */
    public function pause(Request $request)
    {
        $user = auth()->user();

        $timeLog = TimeLog::where('user_id', $user->id)
            ->whereNull('end_time')
            ->first();

        if (!$timeLog) {
            return back()->with('error', 'No active time log found.');
        }

        // For pause functionality, you might want to create a more complex system
        // This is a simple implementation that stops the current log
        $timeLog->update([
            'end_time' => Carbon::now(),
            'duration_minutes' => $timeLog->start_time->diffInMinutes(Carbon::now()),
        ]);

        return back()->with('success', 'Time tracking paused. Total time: ' . $timeLog->duration_minutes . ' minutes.');
    }
}