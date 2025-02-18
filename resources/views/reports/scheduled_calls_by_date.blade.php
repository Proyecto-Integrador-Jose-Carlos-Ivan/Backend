<!DOCTYPE html>
<html>

<head>
    <title>Llistat de Cridades Previstes per Data</title>
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
    <h1>Llistat de Cridades Previstes per Data</h1>
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
                <th>Data</th>
                <th>Zona</th>
                <th>Tipus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alerts as $alert)
            <tr>
                <td>{{ $alert->id }}</td>
                <td>{{ $alert->date }}</td>
                <td>{{ $alert->zona_id }}</td>
                <td>{{ $alert->type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
