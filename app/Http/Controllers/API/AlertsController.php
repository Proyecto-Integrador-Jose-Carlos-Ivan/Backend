<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    public function index(Request $request)
    {
        $alerts = Aviso::all();
        return response()->json($alerts);
    }

    public function store(Request $request)
    {
        $alert = Aviso::create($request->all());
        return response()->json($alert, 201);
    }

    public function show($id)
    {
        $alert = Aviso::findOrFail($id);
        return response()->json($alert);
    }

    public function update(Request $request, $id)
    {
        $alert = Aviso::findOrFail($id);
        $alert->update($request->all());
        return response()->json($alert);
    }

    public function destroy($id)
    {
        $alert = Aviso::findOrFail($id);
        $alert->delete();
        return response()->json(null, 204);
    }
}
