
{{-- resources/views/school/export/pdf/users.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Export</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .school-info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ auth()->user()->school->name ?? 'School' }}</h2>
        <h3>All Users Export Report</h3>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
    </div>

    <div class="school-info">
        <strong>Total Users:</strong> {{ count($data) }}
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->created_at?->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>