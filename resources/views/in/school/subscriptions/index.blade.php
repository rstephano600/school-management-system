@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>School Subscriptions</h4>
        <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">Add New Subscription</a>
    </div>

    <form method="GET" action="{{ route('subscriptions.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by school name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>School</th>
                <th>Category</th>
                <th>Students</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $key => $subscription)
                <tr>
                    <td>{{ $subscriptions->firstItem() + $key }}</td>
                    <td>{{ $subscription->school->name }}</td>
                    <td>{{ $subscription->category->name }}</td>
                    <td>{{ $subscription->total_students }}</td>
                    <td>{{ $subscription->start_date }}</td>
                    <td>{{ $subscription->end_date }}</td>
                    <td>
                        <span class="badge bg-{{ $subscription->is_active ? 'success' : 'danger' }}">
                            {{ $subscription->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No subscriptions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $subscriptions->withQueryString()->links() }}
    </div>
</div>
@endsection
