<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
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
    <h1>Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Zone</th>
                <th>Type</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['zone'] }}</td>
                    <td>{{ $row['type'] }}</td>
                    <td>{{ $row['detail'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
