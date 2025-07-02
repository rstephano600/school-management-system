<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\Classes;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TimetableController extends Controller
{
public function index(Request $request)
{
    $schoolId = auth()->user()->school_id;

    $query = Timetable::with(['teacher.user', 'room', 'class.subject', 'class.section'])
        ->where('school_id', $schoolId);

    // 🔍 Filter by academic year
    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    // 🔍 Filter by class
    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    // 🔍 Search by subject name or teacher name
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('class.subject', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })->orWhereHas('teacher.user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }

    $timetables = $query->orderBy('day_of_week')
                        ->orderBy('period_number')
                        ->paginate(20);

    // Needed for filters
    $classes = \App\Models\Classes::all();
    $academicYears = \App\Models\AcademicYear::all();

    return view('in.school.timetables.index', compact('timetables', 'classes', 'academicYears'));
}

public function create()
{
    $schoolId = auth()->user()->school_id;

    return view('in.school.timetables.create', [
        'classes' => \App\Models\Classes::where('school_id', $schoolId)->get(),
        'teachers' => \App\Models\Teacher::with('user')->where('school_id', $schoolId)->get(),
        'rooms' => \App\Models\Room::where('school_id', $schoolId)->get(),
        'years' => \App\Models\AcademicYear::where('school_id', $schoolId)->get(),
    ]);
}

public function store(Request $request)
{
    $schoolId = auth()->user()->school_id;

    $validated = $request->validate([
        'class_id'         => 'required|exists:classes,id',
        'day_of_week'      => 'required|integer|min:1|max:7',
        'period_number'    => 'required|integer|min:1',
        'start_time'       => 'required|date_format:H:i',
        'end_time'         => 'required|date_format:H:i|after:start_time',
        'effective_from'   => 'required|date',
        'effective_to'     => 'required|date|after_or_equal:effective_from',
    ]);

    // Fetch required values from class
    $class = \App\Models\Classes::findOrFail($validated['class_id']);

    $timetableData = array_merge($validated, [
        'teacher_id'       => $class->teacher_id,
        'room_id'          => $class->room_id,
        'academic_year_id' => $class->academic_year_id,
        'school_id'        => $schoolId,
        'status'           => $request->has('status'),
    ]);

    Timetable::create($timetableData);

    return redirect()->route('timetables.index')->with('success', 'Slot added to timetable.');
}


public function edit(Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    return view('in.school.timetables.edit', [
        'timetable' => $timetable,
        'classes' => \App\Models\Classes::where('school_id', $timetable->school_id)->get(),
        'teachers' => \App\Models\Teacher::with('user')->where('school_id', $timetable->school_id)->get(),
        'rooms' => \App\Models\Room::where('school_id', $timetable->school_id)->get(),
        'years' => \App\Models\AcademicYear::where('school_id', $timetable->school_id)->get(),
    ]);
}

public function update(Request $request, Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    $validated = $request->validate([
        'class_id' => 'required|exists:classes,id',
        'teacher_id' => 'required|exists:teachers,user_id',
        'room_id' => 'nullable|exists:room,id',
        'day_of_week' => 'required|integer|min:1|max:7',
        'period_number' => 'required|integer|min:1',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'academic_year_id' => 'required|exists:academic_years,id',
        'effective_from' => 'required|date',
        'effective_to' => 'required|date|after_or_equal:effective_from',
    ]);

    $validated['status'] = $request->has('status');

    $timetable->update($validated);

    return redirect()->route('timetables.index')->with('success', 'Timetable updated.');
}

public function destroy(Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    $timetable->delete();

    return redirect()->route('timetables.index')->with('success', 'Slot removed.');
}



public function calendarView()
{
    return view('in.school.timetables.calendar');
}

public function calendarEvents(Request $request)
{
    $baseDate = now()->startOfWeek(); // Monday

    $query = \App\Models\Timetable::with(['class.subject', 'teacher.user'])
        ->where('school_id', auth()->user()->school_id);

    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    $events = [];

    foreach ($query->get() as $item) {
        $dayOffset = $item->day_of_week - 1; // 1=Monday → 0 index
        $date = $baseDate->copy()->addDays($dayOffset)->format('Y-m-d');

        $events[] = [
            'title' => $item->class->subject->name . ' (' . ($item->teacher->user->name ?? '') . ')',
            'start' => $date . 'T' . $item->start_time,
            'end'   => $date . 'T' . $item->end_time,
            'color' => '#28a745',
        ];
    }

    return response()->json($events);
}




public function exportExcel(Request $request)
{
    $data = $this->filteredTimetables($request);
    return Excel::download(new \App\Exports\TimetablesExport($data), 'timetables.xlsx');
}

public function exportPdf(Request $request)
{
    $data = $this->filteredTimetables($request);
    $pdf = PDF::loadView('in.school.timetables.export_pdf', ['timetables' => $data]);
    return $pdf->download('timetables.pdf');
}

private function filteredTimetables(Request $request)
{
    $query = \App\Models\Timetable::with(['class.subject', 'teacher.user'])
        ->where('school_id', auth()->user()->school_id);

    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('class.subject', fn($q) => $q->where('name', 'like', "%$search%"))
              ->orWhereHas('teacher.user', fn($q) => $q->where('name', 'like', "%$search%"));
    }

    return $query->get();
}


}
