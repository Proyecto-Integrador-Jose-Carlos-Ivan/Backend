<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = User::where('role', 'operador')->get();
        return view('operators.index', compact('operators'));
    }


    public function create()
    {
        return view('operators.create');
    }

    public function store(Request $request)
    {

        User::create($request->all());

        return redirect()->route('operators.index')->with('success', 'Operator created successfully.');
    }

    public function show(User $operator)
    {
        return view('operators.show', compact('operator'));
    }

    public function edit(User $operator)
    {
        return view('operators.edit', compact('operator'));
    }

    public function update(Request $request, User $operator)
    {

        $operator->update($request->all());

        return redirect()->route('operators.index')->with('success', 'Operator updated successfully.');
    }

    public function destroy(User $operator)
    {
        $operator->delete();
        return redirect()->route('operators.index')->with('success', 'Operator deleted successfully.');
    }
}
