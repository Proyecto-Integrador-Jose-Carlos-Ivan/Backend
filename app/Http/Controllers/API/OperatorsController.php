<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorsController extends Controller
{
    public function index(Request $request)
    {
        $operators = User::all();
        return response()->json($operators);
    }

    public function store(Request $request)
    {
        $operator = User::create($request->all());
        return response()->json($operator, 201);
    }

    public function show($id)
    {
        $operator = User::findOrFail($id);
        return response()->json($operator);
    }

    public function update(Request $request, $id)
    {
        $operator = User::findOrFail($id);
        $operator->update($request->all());
        return response()->json($operator);
    }

    public function destroy($id)
    {
        $operator = User::findOrFail($id);
        $operator->delete();
        return response()->json(null, 204);
    }
}
