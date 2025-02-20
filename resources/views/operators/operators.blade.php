@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold mb-4">Lista de Operadores</h1>

        <form action="{{ route('assign.patients.form') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="operatorId" class="block text-gray-700 text-sm font-bold mb-2">Selecciona un operador:</label>
                <select name="operatorId" id="operatorId" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($operators as $operator)
                        <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Asignar Pacientes</button>
        </form>

        <h2 class="text-xl font-semibold mb-2">Operadores y sus pacientes asignados</h2>
        <ul>
            @foreach ($operators as $operator)
                <li class="mb-4">
                    <div class="flex items-center justify-between py-2">
                        <span class="font-semibold">{{ $operator->name }}</span>
                        <span class="text-sm text-gray-500">Pacientes asignados: {{ count($operator->patients) }}</span>
                    </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre del Paciente
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200"> 
                                @foreach ($operator->patients as $patient)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $patient->nombre }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form action="{{ route('remove.patient') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="operator_id" value="{{ $operator->id }}">
                                                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block color-red">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
