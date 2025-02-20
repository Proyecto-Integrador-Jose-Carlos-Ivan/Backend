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
                        <a href="{{ route('operators.show', $operator->id) }}">
                            <span class="font-semibold">{{ $operator->name }}</span>
                        </a>
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
                                            <div class="flex items-center">
                                                <a href="{{ route('patients.show', $patient->id) }}" class="text-gray-600 hover:text-gray-900 mr-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057-1.836 8.943-9.542 7-7.704-0.001-10.812-4.058-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('remove.patient') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="operator_id" value="{{ $operator->id }}">
                                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block color-red">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
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
