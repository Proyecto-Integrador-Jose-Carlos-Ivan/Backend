<!DOCTYPE html>
<html>
<head>
    <title>Informe de Llamadas Realizadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Informe de Llamadas Realizadas</h1>

    @if(isset($startDate) && isset($endDate))
        <p><strong>Desde:</strong> {{ $startDate->format('Y-m-d') }}</p>
        <p><strong>Hasta:</strong> {{ $endDate->format('Y-m-d') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha y Hora</th>
                <th>Paciente</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                    <td>{{ $call->paciente->nombre}}</td>
                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
