<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreAlertRequestApi;
use App\Http\Requests\UpdateAlertRequestApi;
use App\Http\Resources\AlertResource;
use Illuminate\Http\Request;
use App\Models\Alert;

class AlertsController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $alerts = Alert::all();
            return $this->sendResponse($alerts, 'Alerts retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving alerts.', $e->getMessage());
        }
    }

    public function store(StoreAlertRequestApi $request)
    {
        try {
            $alert = Alert::create($request->validated());
            return $this->sendResponse($alert, 'Alert created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating alert.', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $alert = Alert::findOrFail($id);
            return $this->sendResponse($alert, 'Alert retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Alert not found.', null, 404);
        }
    }

    public function update(UpdateAlertRequestApi $request, $id)
    {
        try {
            $alert = Alert::findOrFail($id);
            $alert->update($request->validated());
            return $this->sendResponse($alert, 'Alert updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating alert.', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $alert = Alert::findOrFail($id);
            $alert->delete();
            return $this->sendResponse(null, 'Alert deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting alert.', $e->getMessage());
        }
    }
}
