<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallsController extends Controller
{
    public function index(Request $request)
    {
        // Listar llamadas. Se puede implementar filtrado por fecha, tipo, zona, etc.
        $calls = Llamada::all();
        return response()->json($calls);
    }

    public function store(Request $request)
    {
        $call = Llamada::create($request->all());
        return response()->json($call, 201);
    }

    public function show($id)
    {
        $call = Llamada::findOrFail($id);
        return response()->json($call);
    }

    public function update(Request $request, $id)
    {
        $call = Llamada::findOrFail($id);
        $call->update($request->all());
        return response()->json($call);
    }

    public function destroy($id)
    {
        $call = Llamada::findOrFail($id);
        $call->delete();
        return response()->json(null, 204);
    }
}
