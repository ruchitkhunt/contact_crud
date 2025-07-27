@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Contact</h3>
    <a href="{{ route('custom_fields.index') }}" class="btn btn-primary">Add Custome Field</a>
</div>




@include('contacts.create')

<hr>
<h3>Contact List</h3>
<div class="row mb-3">
    <div class="col"><input id="search_name" class="form-control" placeholder="Search name"></div>
    <div class="col"><input id="search_email" class="form-control" placeholder="Search email"></div>
    <div class="col">
        <select id="filter_gender" class="form-control">
            <option value="">All genders</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
</div>
<div id="contactResults">
    @include('contacts.list', ['contacts' => $contacts ?? []])
</div>

@endsection