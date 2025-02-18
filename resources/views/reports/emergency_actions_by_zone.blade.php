<!DOCTYPE html>
<html>

<head>
    <title>Actuacions per emergències per zona</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Actuacions per emergències per zona</h1>
    <h2>Zona: {{ $zone->nombre }}</h2>
    <h3>Desde: {{ $startDate }} Hasta: {{ $endDate }}</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data i Hora</th>
                <th>Pacient</th>
                <th>Descripció</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
            <tr>
                <td>{{ $call->id }}</td>
                <td>{{ $call->fecha_hora }}</td>
                <td>{{ $call->paciente->nombre }}</td>
                <td>{{ $call->descripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
