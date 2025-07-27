{{-- resources/views/in/school/payment/categories/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Payment Categories</h4>
        <a href="{{ route('payment.categories.create') }}" class="btn btn-primary">Add New Category</a>
    </div>

    {{-- Filter and Search --}}
    <form method="GET" action="{{ route('payment.categories.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, code, or description">
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">-- Category --</option>
                <option value="school_fee" {{ request('category') == 'school_fee' ? 'selected' : '' }}>School Fee</option>
                <option value="hostel" {{ request('category') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                <!-- Add more categories if needed -->
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">-- Type --</option>
                <option value="mandatory" {{ request('type') == 'mandatory' ? 'selected' : '' }}>Mandatory</option>
                <option value="optional" {{ request('type') == 'optional' ? 'selected' : '' }}>Optional</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('payment.categories.index') }}" class="btn btn-outline-danger w-100">Reset</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paymentCategories as $key => $cat)
                    <tr>
                        <td>{{ $paymentCategories->firstItem() + $key }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->code }}</td>
                        <td>{{ ucfirst($cat->category) }}</td>
                        <td>{{ ucfirst($cat->type) }}</td>
                        <td>{{ $cat->description }}</td>
                        <td>{{ $cat->createdBy->name ?? '-' }}</td>
                        <td>{{ $cat->updatedBy->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('payment.categories.show', $cat->id) }}" class="btn btn-sm btn-info">view</a>
                            <a href="{{ route('payment.categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('payment.categories.destroy', $cat->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">No payment categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $paymentCategories->withQueryString()->links() }}
    </div>
</div>
@endsection
