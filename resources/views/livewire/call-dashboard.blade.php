<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-6 text-gray-800">Call Dashboard</h1>

    <div class="mb-6 flex space-x-4">
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
    </div>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        Llamadas para {{ $date }} en {{ $zone->name ?? 'Todas las Zonas' }}
    </h2>

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