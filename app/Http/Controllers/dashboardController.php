<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
use App\Models\AcademicYear;

public function index()
{
    $schoolId = auth()->user()->school_id;

    $currentYear = AcademicYear::where('school_id', $schoolId)
        ->where('is_current', true)
        ->first();

    return view('in.school.dashboard', compact('currentYear'));
}

    <div class="alert alert-primary">
        <strong>Current Academic Year:</strong> {{ $currentYear->name }}
        ({{ $currentYear->start_date->format('M Y') }} - {{ $currentYear->end_date->format('M Y') }})
    </div>
@else
    <div class="alert alert-warning">
        No academic year marked as current.
    </div>
@endif

}
