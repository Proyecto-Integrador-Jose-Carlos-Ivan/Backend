<!DOCTYPE html>
<html>

<head>
    <title>Llistat de Pacients</title>
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
    <h1>Llistat de Pacients</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>DNI</th>
                <th>Telèfon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->nombre }}</td>
                <td>{{ $patient->dni }}</td>
                <td>{{ $patient->telefono }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
