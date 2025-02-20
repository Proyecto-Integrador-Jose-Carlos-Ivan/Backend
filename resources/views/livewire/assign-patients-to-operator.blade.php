<div class="container mx-auto py-8 pl-4">
    <h1 class="text-2xl font-semibold mb-4">Asignar Pacientes a Operador</h1>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($operator)
        <h2 class="text-xl font-semibold mb-2">Operador: {{ $operator->name }}</h2>

        <input type="text" wire:model.live="search" placeholder="Buscar pacientes..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4" />

        <form wire:submit.prevent="assignPatients" class="mb-4">
            <ul class="divide-y divide-gray-200">
                @foreach ($patients as $patient)
                    <li class="py-4">
                        <label class="flex items-center">
                            <input type="checkbox" value="{{ $patient->id }}" wire:model.live="selectedPatients" class="mr-2 h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">
                                {{ $patient->nombre }} {{ $patient->apellidos }} - Teléfono: {{ $patient->telefono }}
                            </span>
                        </label>
                    </li>
                @endforeach
            </ul>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">Asignar Pacientes</button>
        </form>

        {{ $patients->links() }}
    @else
        <p>Operador no encontrado.</p>
    @endif
</div>
