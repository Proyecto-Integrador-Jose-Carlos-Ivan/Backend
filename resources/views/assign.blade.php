@extends('layouts.app')

@section('content')
    <div class="container">
        @livewire('assign-patients-to-operator', ['operatorId' => $operatorId])
    </div>
@endsection
