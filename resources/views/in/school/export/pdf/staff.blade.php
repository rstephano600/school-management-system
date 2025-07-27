{{-- resources/views/school/export/pdf/staff.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Staff Export</title>
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
        <h3>Staff Export Report</h3>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
    </div>

    <div class="school-info">
        <strong>Total Staff:</strong> {{ count($data) }}
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
            @foreach($data as $staff)
                <tr>
                    <td>{{ $staff->employee_id }}</td>
                    <td>{{ $staff->user->name }}</td>
                    <td>{{ $staff->user->email }}</td>
                    <td>{{ $staff->joining_date?->format('Y-m-d') }}</td>
                    <td>{{ $staff->designation }}</td>
                    <td>{{ $staff->department }}</td>
                    <td>{{ $staff->qualification }}</td>
                    <td>{{ $staff->experience }}</td>
                    <td>{{ $staff->status ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>