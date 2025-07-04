@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Division Details</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Division: {{ $division->division }}</h5>

            <ul class="list-group list-group-flush">
<li class="list-group-item"><strong>Min Point:</strong> {{ $division->min_point }}</li>
                <li class="list-group-item"><strong>Max Point:</strong> {{ $division->max_point }}</li>
                <li class="list-group-item"><strong>Remarks:</strong> {{ $division->remarks ?? 'None' }}</li>
                <li class="list-group-item"><strong>Created By:</strong> {{ $division->creator->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Last Updated By:</strong> {{ $division->updater->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Created At:</strong> {{ $division->created_at->format('d M Y, H:i') }}</li>
                <li class="list-group-item"><strong>Updated At:</strong> {{ $division->updated_at->format('d M Y, H:i') }}</li>
            </ul>

            <div class="mt-3">
                <a href="{{ route('divisions.edit', $division) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('divisions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
