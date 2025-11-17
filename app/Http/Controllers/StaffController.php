<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of staff
     */
    public function index()
    {
        $staff = User::where('role', 'staff')->latest()->get();
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created staff
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'is_active' => true,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified staff
     */
    public function show(User $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff
     */
    public function edit(User $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff
     */
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'is_active' => 'boolean',
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff
     */
    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }
}