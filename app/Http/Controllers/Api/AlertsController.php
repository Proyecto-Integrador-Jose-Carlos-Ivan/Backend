<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;

class AlertsController extends Controller
{
    public function index(Request $request)
    {
        $alerts = Alert::all();
        return response()->json($alerts);
    }

    public function store(Request $request)
    {
        $alert = Alert::create($request->all());
        return response()->json($alert, 201);
    }

    public function show($id)
    {
        $alert = Alert::findOrFail($id);
        return response()->json($alert);
    }

    public function update(Request $request, $id)
    {
        $alert = Alert::findOrFail($id);
        $alert->update($request->all());
        return response()->json($alert);
    }

    public function destroy($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        return response()->json(null, 204);
    }
}
