<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = User::all();
        return view('operators.index', compact('operators'));
    }

    public function create()
    {
        return view('operators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $operator->id,
        ]);

        $operator->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('operators.index')->with('success', 'Operator updated successfully.');
    }

    public function destroy(User $operator)
    {
        $operator->delete();
        return redirect()->route('operators.index')->with('success', 'Operator deleted successfully.');
    }
}
