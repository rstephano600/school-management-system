{{-- resources/views/school/export/pdf/parents.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Parents Export</title>
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
        <h3>Parents Export Report</h3>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
    </div>

    <div class="school-info">
        <strong>Total Parents:</strong> {{ count($data) }}
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
            @foreach($data as $parent)
                <tr>
                    <td>{{ $parent->user->name }}</td>
                    <td>{{ $parent->user->email }}</td>
                    <td>{{ $parent->student->user->name ?? '' }}</td>
                    <td>{{ ucfirst($parent->relation_type) }}</td>
                    <td>{{ $parent->occupation }}</td>
                    <td>{{ $parent->education }}</td>
                    <td>{{ $parent->company }}</td>
                    <td>{{ $parent->annual_income }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
