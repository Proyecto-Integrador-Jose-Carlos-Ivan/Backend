<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-6 text-gray-800">Listado de llamadas</h1>

    <div class="mb-6 flex flex-wrap space-x-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" id="date" wire:model="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="zone" class="block text-sm font-medium text-gray-700">Zona</label>
            <select id="zone" wire:model="zone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Todas las Zonas</option>
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="operator" class="block text-sm font-medium text-gray-700">Operador</label>
            <select id="operator" wire:model="operator" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Todos los Operadores</option>
                @foreach ($operators as $operator)
                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="patient" class="block text-sm font-medium text-gray-700">Paciente</label>
            <select id="patient" wire:model="patient" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Todos los Pacientes</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <button wire:click="applyFilters" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Aplicar Filtros
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Hora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paciente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sentido</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aviso ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zona</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($calls as $call)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->fecha_hora }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->operador->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->paciente->nombre }}</td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->descripcion }}</td> --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->sentido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->categoria }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->subtipo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->aviso_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $call->zona ? $call->zona->name : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>