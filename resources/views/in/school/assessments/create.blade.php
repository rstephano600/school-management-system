@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Assessment</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Form has errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
       @include('in.school.assessments.form')
</div>
@endsection
