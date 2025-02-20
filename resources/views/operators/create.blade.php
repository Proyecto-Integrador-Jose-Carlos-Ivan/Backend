@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Crear Operador</h1>

        <form action="{{ route('operators.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el nombre">
            </div>
             <div class="mb-4">
                <label for="apellidos" class="block text-gray-700 text-sm font-bold mb-2">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa los apellidos">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electronico:</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el correo">
            </div>
             <div class="mb-4">
                <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingresa el teléfono">
            </div>
             <div class="mb-4">
                <label for="lenguas" class="block text-gray-700 text-sm font-bold mb-2">Lenguas:</label>
                <select id="lenguas" name="lenguas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="español">Español</option>
                    <option value="ingles">Inglés</option>
                    <option value="arabe">Árabe</option>
                    </select>
            </div>
             <div class="mb-4">
                <label for="fecha_contratacion" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Contratación:</label>
                <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="fecha_baja" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Baja:</label>
                <input type="date" id="fecha_baja" name="fecha_baja" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Crear Operador
                </button>
            </div>
        </form>
    </div>
@endsection