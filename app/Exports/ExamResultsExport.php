<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExamResultsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    /**
     * Return collection of exam results
     */
    public function collection()
    {
        return $this->results;
    }

    /**
     * Define the headings for the export
     */
    public function headings(): array
    {
        return [
            'Admission Number',
            'Student Name',
            'Grade/Class',
            'Section',
            'Academic Year',
            'Semester',
            'Exam Type',
            'Subject',
            'Total Marks',
            'Marks Obtained',
            'Percentage',
            'Grade',
            'Remarks',
            'Published Date',
            'Published By'
        ];
    }

    /**
     * Map each result to export format
     */
    public function map($result): array
    {
        $percentage = $result->exam->total_marks > 0 ? 
            round(($result->marks_obtained / $result->exam->total_marks) * 100, 2) : 0;

        $studentName = trim($result->student->fname . ' ' . 
                           ($result->student->mname ? $result->student->mname . ' ' : '') . 
                           $result->student->lname);

        return [
            $result->student->admission_number ?? 'N/A',
            $studentName,
            $result->student->grade->name ?? 'N/A',
            $result->student->section->name ?? 'N/A',
            $result->exam->academicYear->name ?? 'N/A',
            $result->exam->semester->name ?? 'N/A',
            $result->exam->examType->name ?? 'N/A',
            $result->exam->subject->name ?? 'N/A',
            $result->exam->total_marks ?? 0,
            $result->marks_obtained ?? 0,
            $percentage . '%',
            $result->grade ?? 'N/A',
            $result->remarks ?? '',
            $result->published_at ? $result->published_at->format('Y-m-d H:i:s') : 'N/A',
            $result->publisher ? $result->publisher->user->name : 'N/A'
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style for the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFE0E0E0',
                    ],
                ],
            ],
            // Style for all cells
            'A:O' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
            // Style for percentage column
            'K:K' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            // Style for marks columns
            'I:J' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}