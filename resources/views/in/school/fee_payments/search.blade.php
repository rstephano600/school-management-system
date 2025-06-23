@extends('layouts.app')

@section('title', 'Search Students - Record Payment')

@section('content')
<div class="container">
    <h3 class="mb-4">Search Student to Record Payment</h3>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control" placeholder="Search by name or admission number" value="{{ $query ?? '' }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
    </form>

    @if($students->isEmpty())
        <div class="alert alert-info">No students found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Admission Number</th>
                        <th>Email</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->admission_number ?? '-' }}</td>
                        <td>{{ $student->email }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.fee-payments.create', $student->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-money-check"></i> Record Payment
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $students->appends(['q' => $query])->links() }}
        </div>
    @endif
</div>
@endsection
