<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ContactPerson as Contact;
use App\Http\Requests\StoreContactRequestApi;
use App\Http\Requests\UpdateContactRequestApi;

class ContactsController extends BaseController
{
    public function index(Request $request, $patientId)
    {
        try {
            // Listar contactos de un paciente
            $contacts = Contact::where('paciente_id', $patientId)->get();
            return $this->sendResponse($contacts, 'Contacts retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving contacts.', $e->getMessage());
        }
    }

    public function store(StoreContactRequestApi $request, $patientId)
    {
        try {
            $data = $request->all();
            $data['paciente_id'] = $patientId;
            $contact = Contact::create($data);
            return $this->sendResponse($contact, 'Contact created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating contact.', $e->getMessage());
        }
    }

    public function update(UpdateContactRequestApi $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->update($request->all());
            return $this->sendResponse($contact, 'Contact updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating contact.', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return $this->sendResponse(null, 'Contact deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting contact.', $e->getMessage());
        }
    }
}
