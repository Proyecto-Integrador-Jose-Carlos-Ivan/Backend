<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OperatorsController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $operators = User::all();
            return $this->sendResponse($operators, 'Operators retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving operators.', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        try {
            $operator = User::create($request->all());
            return $this->sendResponse($operator, 'Operator created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating operator.', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $operator = User::findOrFail($id);
            return $this->sendResponse($operator, 'Operator retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Operator not found.', null, 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $operator = User::findOrFail($id);

             $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email,'.$id,
                'password' => 'string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $operator->update($request->all());
            return $this->sendResponse($operator, 'Operator updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating operator.', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $operator = User::findOrFail($id);
            $operator->delete();
            return $this->sendResponse(null, 'Operator deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting operator.', $e->getMessage());
        }
    }
}
