<!DOCTYPE html>
<html>
<head>
    <title>Emergencies Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: wheat; }
    </style>
</head>
<body>
    <h1>Informe de llamadas de emergencia</h1>
    <p><strong>Fecha de inicio:</strong> {{ $startDate }}</p>
    <p><strong>Fecha de fin:</strong> {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Operador</th>
                <th>Fecha/Hora</th>
                <th>Categoria</th>
                <th>Zona</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->paciente->nombre }}</td>
                    <td>{{ $call->operador->name }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                    <td>{{ 'Emergencia' }}</td>
                    <td>{{ $call->zona->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
