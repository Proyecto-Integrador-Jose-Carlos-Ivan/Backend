<!DOCTYPE html>
<html>
<head>
    <title>Scheduled Calls Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Scheduled Calls Report</h1>
    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>

    <h2>Alerts with Calls</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Zone ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alertsWithCalls as $alert)
                <tr>
                    <td>{{ $alert->id }}</td>
                    <td>{{ $alert->date }}</td>
                    <td>{{ $alert->zoneId }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Alerts without Calls</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Zone ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alertsWithoutCalls as $alert)
                <tr>
                    <td>{{ $alert->id }}</td>
                    <td>{{ $alert->date }}</td>
                    <td>{{ $alert->zoneId }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
