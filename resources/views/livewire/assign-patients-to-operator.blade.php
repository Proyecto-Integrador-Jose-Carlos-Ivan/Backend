@extends('layouts.app')

@section('content')
<div>
    <h1>Asignar Pacientes a Operador</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($operator)
        <h2>Operador: {{ $operator->name }}</h2>

        <input type="text" wire:model="search" placeholder="Buscar pacientes..." />

        <form wire:submit.prevent="assignPatients">
            <ul>
                @foreach ($patients as $patient)
                    <li>
                        <input type="checkbox" value="{{ $patient->id }}" wire:model="selectedPatients">
                        {{ $patient->nombre }}
                    </li>
                @endforeach
            </ul>

            <button type="submit">Asignar Pacientes</button>
        </form>

        {{ $patients->links() }}
    @else
        <p>Operador no encontrado.</p>
    @endif
</div>
@endsection
