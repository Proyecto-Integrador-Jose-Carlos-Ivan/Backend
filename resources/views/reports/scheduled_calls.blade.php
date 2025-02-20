<!DOCTYPE html>
<html>
<head>
    <title>Llamadas previstas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Informe de llamadas programadas</h1>

    <h2>Llamadas programadas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Descripcion</th>
                <th>Categoria</th>
                <th>Motivo</th>
                <th>Zona</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->fecha_hora }}</td>
                    <td>{{ $call->paciente->nombre }}</td>
                    <td>{{ $call->descripcion }}</td>
                    <td>{{ $call->categoria }}</td>
                    <td>{{ $call->subtipo }}</td>
                    <td>{{ $call->zona->name }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
