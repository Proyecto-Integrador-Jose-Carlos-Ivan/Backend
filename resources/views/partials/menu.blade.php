<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('operators.index')" :active="request()->routeIs('operators.index')">
        {{ __('Operadors') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('zones.index')" :active="request()->routeIs('zones.index')">
        {{ __('Zonas') }}
    </x-nav-link>
</div>
{{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('partits.historic')" :active="request()->routeIs('partits.historic')">
        {{ __('Històric Partits') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('partits.jornades')" :active="request()->routeIs('partits.jornades')">
        {{ __('Calendari de jornades') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('equips.classificacio')" :active="request()->routeIs('equips.classificacio')">
        {{ __('Classificacio') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('enviar.calendari.anual')" :active="request()->routeIs('enviar.calendari.anual')">
        {{ __('Enviar calendaris') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('jugadores.index')" :active="request()->routeIs('jugadores.index')">
        {{ __('Jugadores') }}
    </x-nav-link>
</div> --}}
