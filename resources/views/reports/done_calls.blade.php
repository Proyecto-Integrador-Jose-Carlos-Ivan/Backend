<!DOCTYPE html>
<html>
<head>
    <title>Done Calls Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Done Calls Report</h1>
    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>

    <h2>Incoming Calls</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha/Hora</th>
                <th>Paciente ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomingCalls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                    <td>{{ $call->patientId }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Outgoing Calls</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha/Hora</th>
                <th>Paciente ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outgoingCalls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                    <td>{{ $call->patientId }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
