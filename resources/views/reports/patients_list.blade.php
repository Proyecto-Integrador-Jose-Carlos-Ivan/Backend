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
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>SIP</th>
                <th>Telefono</th>
                <th>Zona</th>
                <th>Email</th>
                <th>Situacion Personal</th>
                <th>Situacion Sanitaria</th>
                <th>Situacion Economica</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->nombre }}</td>
                <td>{{ $patient->apellidos }}</td>
                <td>{{ $patient->dni }}</td>
                <td>{{ $patient->sip }}</td>
                <td>{{ $patient->telefono }}</td>
                <td>{{ $patient->zona->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->situacion_personal }}</td>
                <td>{{ $patient->situacion_sanitaria }}</td>
                <td>{{ $patient->situacion_economica }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
