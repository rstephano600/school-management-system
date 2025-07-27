{{-- resources/views/school/export/pdf/students.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students Export</title>
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
        <h3>Students Export Report</h3>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
    </div>

    <div class="school-info">
        <strong>Total Students:</strong> {{ count($data) }}
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
            @foreach($data as $student)
                <tr>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ $student->fname }}</td>
                    <td>{{ $student->mname }}</td>
                    <td>{{ $student->lname }}</td>
                    <td>{{ $student->grade->name ?? '' }}</td>
                    <td>{{ $student->section->name ?? '' }}</td>
                    <td>{{ $student->roll_number }}</td>
                    <td>{{ $student->date_of_birth?->format('Y-m-d') }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->blood_group }}</td>
                    <td>{{ $student->religion }}</td>
                    <td>{{ $student->nationality }}</td>
                    <td>{{ $student->admission_date?->format('Y-m-d') }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ $student->is_transport ? 'Yes' : 'No' }}</td>
                    <td>{{ $student->is_hostel ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>





