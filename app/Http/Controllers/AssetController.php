<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\User;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('assignedTo')->latest()->get();
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $staff = User::where('role', 'staff')->active()->get();
        return view('assets.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:assets',
            'category' => 'required|in:laptop,mobile,tablet,monitor,accessory,furniture,other',
            'description' => 'nullable|string',
            'purchase_price' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'status' => 'required|in:available,assigned,maintenance,retired',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        Asset::create($request->all());

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    public function assign(Request $request, Asset $asset)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $asset->update([
            'assigned_to' => $request->assigned_to,
            'assigned_date' => now(),
            'status' => 'assigned',
        ]);

        return back()->with('success', 'Asset assigned successfully.');
    }

    public function unassign(Asset $asset)
    {
        $asset->update([
            'assigned_to' => null,
            'assigned_date' => null,
            'status' => 'available',
        ]);

        return back()->with('success', 'Asset unassigned successfully.');
    }
}