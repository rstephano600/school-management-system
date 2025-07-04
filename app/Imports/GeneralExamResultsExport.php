<?php

namespace App\Exports;

use App\Models\ExamResult;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GeneralExamResultsExport implements FromView
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function view(): View
    {
        return view('in.school.exams.results.exports.general_excel', [
            'results' => $this->results
        ]);
    }
}
