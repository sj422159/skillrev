@extends('nontechmanager/hostel/layout')
@section('container')
<div class="container">
    <h2>Subcategory Details</h2>
    <a href="{{ route('subcategory.index') }}" class="btn btn-secondary mb-3">Back to Subcategories</a>
    <a href="{{ route('subcategory.create') }}" class="btn btn-primary mb-3">Add New Subcategory</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Group</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
    <tr>
        <td>{{ $subcategory->subcategory }}</td>
        <td>{{ $subcategory->groupid }}</td>
        <td>{{ $subcategory->categoryid }}</td>
    </tr>
@endforeach

      
