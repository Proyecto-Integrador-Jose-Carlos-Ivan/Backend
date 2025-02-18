@extends('layouts.app')

@section('title', __('LLamadas entrantes y salientes' ))

@section('content')

    <!-- Afegim el component Livewire aquí -->
    <div class="mt-8">
        @livewire('call-dashboard')
    </div>
@endsection