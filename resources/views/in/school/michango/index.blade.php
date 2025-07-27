@extends('layouts.app')

{{-- index.blade.php --}}
@section('content')
<div class="container">
    <h4 class="mb-4">Michango Categories</h4>

    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by name or description" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div class="col-md-2 ms-auto">
            <a href="{{ route('michango.create') }}" class="btn btn-success">New Michango</a>
        </div>
    </form>

    <div class="mb-3">
        <strong>Total:</strong> {{ $stats['total_categories'] }} |
        <strong>Active:</strong> {{ $stats['active_categories'] }} |
        <strong>Target:</strong> {{ number_format($stats['total_target']) }} |
        <strong>Collected:</strong> {{ number_format($stats['total_collected']) }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Target</th>
                <th>Collected</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($michangoCategories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ number_format($category->target_amount) }}</td>
                    <td>{{ number_format($category->collected_amount) }}</td>
                    <td>{{ $category->end_date }}</td>
                    <td>
                        @if ($category->collected_amount >= $category->target_amount)
                            <span class="badge bg-success">Completed</span>
                        @elseif ($category->end_date < now())
                            <span class="badge bg-secondary">Expired</span>
                        @else
                            <span class="badge bg-info">Active</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('michango.show', $category->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $michangoCategories->links() }}
</div>
@endsection