<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zona;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $zones = Zona::all();
        return response()->json($zones);
    }

    public function show($id)
    {
        $zone = Zona::findOrFail($id);
        return response()->json($zone);
    }

    // Ejemplo para listar pacientes de una zona
    public function patients($id)
    {
        $zone = Zona::findOrFail($id);
        // Asumiendo que Zona tiene relación 'pacientes'
        return response()->json($zone->pacientes);
    }

    // Ejemplo para listar operadores asignados a una zona
    public function operators($id)
    {
        $zone = Zona::findOrFail($id);
        // Asumiendo que Zona tiene relación 'operadores'
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
