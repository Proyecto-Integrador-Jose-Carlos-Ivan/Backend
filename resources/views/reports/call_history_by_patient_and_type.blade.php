<!DOCTYPE html>
<html>

<head>
    <title>Històric de Cridades per Beneficiari i Tipus</title>
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
    <h1>Històric de Cridades per Beneficiari i Tipus</h1>
    <h2>Pacient: {{ $patient->nombre }}</h2>
    @if($type)
    <h3>Tipus: {{ $type }}</h3>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha i Hora</th>
                <th>Categoria</th>
                <th>Sentit</th>
                <th>Zona</th>
                <th>Operador</th>

            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
            <tr>
                <td>{{ $call->id }}</td>
                <td>{{ $call->fecha_hora }}</td>
                <td>{{ $call->categoria }}</td>
                <td>{{ $call->sentido }}</td>
                <td>{{ $call->zona->name ?? 'N/A' }}</td>
                <td>{{ $call->operador->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
