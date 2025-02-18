<!DOCTYPE html>
<html>

<head>
    <title>Llistat de Cridades Fet per Data</title>
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
    <h1>Llistat de Cridades Fet per Data</h1>
    <h2>Data: {{ $date }}</h2>
    @if($type)
    <h3>Tipus: {{ $type }}</h3>
    @endif
    @if($zona_id)
    <h3>Zona: {{ $zona_id }}</h3>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data i Hora</th>
                <th>Pacient</th>
                <th>Categoria</th>
                <th>Sentit</th>
                <th>Zona</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
            <tr>
                <td>{{ $call->id }}</td>
                <td>{{ $call->fecha_hora }}</td>
                <td>{{ $call->paciente->nombre }}</td>
                <td>{{ $call->categoria }}</td>
                <td>{{ $call->sentido }}</td>
                <td>{{ $call->zona->nombre ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
