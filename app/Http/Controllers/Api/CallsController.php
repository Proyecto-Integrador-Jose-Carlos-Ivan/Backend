<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Call;

class CallsController extends Controller
{
    public function index(Request $request)
    {
        // Listar Calls. Se puede implementar filtrado por fecha, tipo, zona, etc.
        $calls = Call::all();
        return response()->json($calls);
    }

    public function store(Request $request)
    {
        $call = Call::create($request->all());
        return response()->json($call, 201);
    }

    public function show($id)
    {
        $call = Call::findOrFail($id);
        return response()->json($call);
    }

    public function update(Request $request, $id)
    {
        $call = Call::findOrFail($id);
        $call->update($request->all());
        return response()->json($call);
    }

    public function destroy($id)
    {
        $call = Call::findOrFail($id);
        $call->delete();
        return response()->json(null, 204);
    }
}
