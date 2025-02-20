@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Editar Operador</h1>

        <form action="{{ route('operators.update', $operator) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $operator->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el nombre">
            </div>

            <div class="mb-4">
                <label for="apellidos" class="block text-gray-700 text-sm font-bold mb-2">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos', $operator->apellidos) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa los apellidos">
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electrónico:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $operator->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el correo">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $operator->phone) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el teléfono">
            </div>

            <div class="mb-4">
                <label for="languages" class="block text-gray-700 text-sm font-bold mb-2">Idiomas:</label>
                <select id="languages" name="languages[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                    <option value="español" {{ in_array('español', old('languages', $operator->languages ?? [])) ? 'selected' : '' }}>Español</option>
                    <option value="inglés" {{ in_array('inglés', old('languages', $operator->languages ?? [])) ? 'selected' : '' }}>Inglés</option>
                    <option value="árabe" {{ in_array('árabe', old('languages', $operator->languages ?? [])) ? 'selected' : '' }}>Árabe</option>
                    <!-- Add more languages as needed -->
                </select>
            </div>

            <div class="mb-4">
                <label for="hire_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Contratación:</label>
                <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date', $operator->hire_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="termination_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Baja:</label>
                <input type="date" id="termination_date" name="termination_date" value="{{ old('termination_date', $operator->termination_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Operador
                </button>
            </div>
        </form>
    </div>
@endsection