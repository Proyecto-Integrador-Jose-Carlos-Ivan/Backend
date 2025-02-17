<div>
    <h1>Call Dashboard</h1>

    <div>
        <label for="date">Date:</label>
        <input type="date" id="date" wire:model.live="date">
    </div>

    <div>
        <label for="zone">Zone:</label>
        <select id="zone" wire:model.live="zone">
            <option value="">All Zones</option>
            @foreach ($zones as $zone)
                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
            @endforeach
        </select>
    </div>

    <h2>Calls for {{ $date }} in {{ $zone ? \App\Models\Zone::find($zone)->name : 'All Zones' }}</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Zone</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->date }}</td>
                    <td>{{ $call->zone->name }}</td>
                    <td>{{ $call->type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
