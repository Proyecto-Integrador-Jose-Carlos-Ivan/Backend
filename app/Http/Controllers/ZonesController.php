<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    /**
     * Display a listing of the zones.
     */
    public function index()
    {
        $zones = Zone::all();
        return view('zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new zone.
     */
    public function create()
    {
        return view('zones.create');
    }

    /**
     * Store a newly created zone in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Zone::create($request->only('name'));

        return redirect()->route('zones.index')->with('success', 'Zone created successfully.');
    }

    /**
     * Display the specified zone.
     */
    public function show(Zone $zone)
    {
        return view('zones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified zone.
     */
    public function edit(Zone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    /**
     * Update the specified zone in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $zone->update($request->only('name'));

        return redirect()->route('zones.index')->with('success', 'Zone updated successfully.');
    }

    /**
     * Remove the specified zone from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zones.index')->with('success', 'Zone deleted successfully.');
    }
}