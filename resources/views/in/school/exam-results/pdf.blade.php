<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Results Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-size: 9px;
        }

        .results-table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .results-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .results-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .grade-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
            text-align: center;
            min-width: 20px;
        }

        .grade-a { background-color: #28a745; color: white; }
        .grade-b { background-color: #007bff; color: white; }
        .grade-c { background-color: #ffc107; color: black; }
        .grade-d { background-color: #17a2b8; color: white; }
        .grade-f { background-color: #dc3545; color: white; }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
            text-align: center;
        }

        .status-passed { background-color: #28a745; color: white; }
        .status-failed { background-color: #dc3545; color: white; }

        .statistics {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #666; }

        @media print {
            body { font-size: 10px; }
            .results-table th,
            .results-table td { padding: 6px; font-size: 8px; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Examination Results Report</h1>
        <p>Generated on {{ now()->format('F d, Y \a\t H:i A') }}</p>
    </div>

    <!-- Summary Statistics -->
    @php
        $totalStudents = $results->pluck('student_id')->unique()->count();
        $totalExams = $results->pluck('exam_id')->unique()->count();
        $averageMarks = $results->avg('marks_obtained');
        $highestMarks = $results->max('marks_obtained');
        $lowestMarks = $results->min('marks_obtained');
        $passCount = $results->filter(function($result) {
            return $result->marks_obtained >= $result->exam->passing_marks;
        })->count();
        $passRate = $results->count() > 0 ? ($passCount / $results->count()) * 100 : 0;
    @endphp

    <div class="statistics">
        <div class="stat-item">
            <div class="stat-value">{{ $totalStudents }}</div>
            <div class="stat-label">Total Students</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $totalExams }}</div>
            <div class="stat-label">Total Exams</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ number_format($averageMarks, 1) }}</div>
            <div class="stat-label">Average Marks</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $highestMarks }}</div>
            <div class="stat-label">Highest Score</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $lowestMarks }}</div>
            <div class="stat-label">Lowest Score</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ number_format($passRate, 1) }}%</div>
            <div class="stat-label">Pass Rate</div>
        </div>
    </div>

    <!-- Export Information -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Total Records:</span>
            <span>{{ $results->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Export Date:</span>
            <span>{{ now()->format('F d, Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Report Type:</span>
            <span>Comprehensive Examination Results</span>
        </div>
    </div>

    <!-- Results Table -->
    <table class="results-table">
        <thead>
            <tr>
                <th style="width: 8%;">S/N</th>
                <th style="width: 10%;">Admission No.</th>
                <th style="width: 18%;">Student Name</th>
                <th style="width: 8%;">Class</th>
                <th style="width: 12%;">Academic Year</th>
                <th style="width: 10%;">Semester</th>
                <th style="width: 10%;">Exam Type</th>
                <th style="width: 12%;">Subject</th>
                <th style="width: 8%;">Marks</th>
                <th style="width: 6%;">Grade</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $result->student->admission_number }}</td>
                    <td>
                        {{ $result->student->fname }} 
                        {{ $result->student->mname ? $result->student->mname . ' ' : '' }}
                        {{ $result->student->lname }}
                    </td>
                    <td class="text-center">
                        {{ $result->student->grade->name ?? 'N/A' }}-{{ $result->student->section->name ?? 'N/A' }}
                    </td>
                    <td>{{ $result->exam->academicYear->name ?? 'N/A' }}</td>
                    <td>{{ $result->exam->semester->name ?? 'N/A' }}</td>
                    <td>{{ $result->exam->examType->name ?? 'N/A' }}</td>
                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                    <td class="text-center">
                        <div class="fw-bold">{{ $result->marks_obtained }}/{{ $result->exam->total_marks }}</div>
                        <div class="text-muted" style="font-size: 8px;">
                            @if($result->exam->total_marks > 0)
                                ({{ number_format(($result->marks_obtained / $result->exam->total_marks) * 100, 1) }}%)
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $gradeClass = match(strtoupper($result->grade)) {
                                'A+', 'A' => 'grade-a',
                                'B+', 'B' => 'grade-b',
                                'C+', 'C' => 'grade-c',
                                'D+', 'D' => 'grade-d',
                                'F' => 'grade-f',
                                default => 'grade-d'
                            };
                        @endphp
                        <span class="grade-badge {{ $gradeClass }}">{{ $result->grade }}</span>
                    </td>
                    <td class="text-center">
                        @php
                            $isPassed = $result->marks_obtained >= $result->exam->passing_marks;
                        @endphp
                        <span class="status-badge {{ $isPassed ? 'status-passed' : 'status-failed' }}">
                            {{ $isPassed ? 'PASS' : 'FAIL' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($results->count() == 0)
        <div style="text-align: center; padding: 50px; color: #666;">
            <h3>No Results Found</h3>
            <p>No examination results match the selected criteria.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>
            This report contains {{ $results->count() }} examination result(s) | 
            Generated by School Management System | 
            {{ now()->format('Y') }} &copy; All Rights Reserved
        </p>
        <p style="margin-top: 5px;">
            <strong>Note:</strong> This is a computer-generated document and does not require a signature.
        </p>
    </div>
</body>
</html>