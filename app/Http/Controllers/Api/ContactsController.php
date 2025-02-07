<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index(Request $request, $patientId)
    {
        // Listar contactos de un paciente
        $contacts = Contact::where('paciente_id', $patientId)->get();
        return response()->json($contacts);
    }

    public function store(Request $request, $patientId)
    {
        $data = $request->all();
        $data['paciente_id'] = $patientId;
        $contact = Contact::create($data);
        return response()->json($contact, 201);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json(null, 204);
    }
}
