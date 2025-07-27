@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Custom Fields</h2>
    <a href="{{ route('contacts.index') }}" class="btn btn-primary">Add Contact</a>
</div>


<form method="post" action="{{ route('custom-fields.store') }}" id="customFieldForm">
    @csrf
    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label for="field_name">Field Name</label>
                <input type="text" class="form-control" name="field_name" value="{{ old('field_name') }}">
                @error('field_name')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label for="field_type">Select Field Type</label>
                <select class="form-control" name="field_type">
                    <option value="">Select Field Type</option>
                    <option value="text" {{ old('field_type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="textarea" {{ old('field_type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                    <option value="date" {{ old('field_type') == 'date' ? 'selected' : '' }}>Date</option>
                </select>
                @error('field_type')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

        </div>

    </div>

    <div class="mt-3">
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
</form>

@endsection