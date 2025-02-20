@extends('layouts.app')

@section('title', __('Asignar paciente a operador' ))

@section('content')

    <!-- Afegim el component Livewire aquí -->
    <div class="mt-8">
        @livewire('assign-patients-to-operator')
    </div>
@endsection