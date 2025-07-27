{{-- resources/views/school/export/pdf/teachers.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teachers Export</title>
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
        <h3>Teachers Export Report</h3>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
    </div>

    <div class="school-info">
        <strong>Total Teachers:</strong> {{ count($data) }}
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
            @foreach($data as $teacher)
                <tr>
                    <td>{{ $teacher->employee_id }}</td>
                    <td>{{ $teacher->user->name }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>{{ $teacher->joining_date?->format('Y-m-d') }}</td>
                    <td>{{ $teacher->qualification }}</td>
                    <td>{{ $teacher->specialization }}</td>
                    <td>{{ $teacher->experience }}</td>
                    <td>{{ $teacher->department }}</td>
                    <td>{{ $teacher->is_class_teacher ? 'Yes' : 'No' }}</td>
                    <td>{{ $teacher->status ? 'Active' : 'Inactive' }}</td>
                    <td>{{ $teacher->subjects->pluck('name')->join(', ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>