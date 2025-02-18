<!DOCTYPE html>
<html>
<head>
    <title>Patient History Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Patient History Report</h1>
    @if($patient)
        <h2>Patient: {{ $patient->nombre }} {{ $patient->apellido }}</h2>
    @endif
    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha/Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
