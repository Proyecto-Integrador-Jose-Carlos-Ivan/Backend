<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Http\Requests\StoreCallRequestApi;
use App\Http\Requests\UpdateCallRequestApi;
class CallsController extends BaseController
{
    public function index(Request $request)
    {
        try {
            // Listar Calls. Se puede implementar filtrado por fecha, tipo, zona, etc.
            $calls = Call::all();
            return $this->sendResponse($calls, 'Calls retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving calls.', $e->getMessage());
        }
    }

    public function store(StoreCallRequestApi $request)
    {
        try {
            $call = Call::create($request->all());
            return $this->sendResponse($call, 'Call created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating call.', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $call = Call::findOrFail($id);
            return $this->sendResponse($call, 'Call retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Call not found.', null, 404);
        }
    }

    public function update(UpdateCallRequestApi $request, $id)
    {
        try {
            $call = Call::findOrFail($id);
            $call->update($request->all());
            return $this->sendResponse($call, 'Call updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating call.', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $call = Call::findOrFail($id);
            $call->delete();
            return $this->sendResponse(null, 'Call deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting call.', $e->getMessage());
        }
    }
}
