<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $zones = Zone::all();
        return response()->json($zones);
    }

    public function show($id)
    {
        $zone = Zone::findOrFail($id);
        return response()->json($zone);
    }

    // Ejemplo para listar pacientes de una Zone
    public function patients($id)
    {
        $zone = Zone::findOrFail($id);
        // Asumiendo que Zone tiene relación 'pacientes'
        return response()->json($zone->pacientes);
    }

    // Ejemplo para listar operadores asignados a una Zone
    public function operators($id)
    {
        $zone = Zone::findOrFail($id);
        // Asumiendo que Zone tiene relación 'operadores'
        return response()->json($zone->operadores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
