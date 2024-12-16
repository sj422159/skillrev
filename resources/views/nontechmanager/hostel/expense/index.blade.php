@extends('nontechmanager/hostel/layout')

@section('container')
<div class="container">
    <h2>Expense Subcategories</h2>
    <a href="{{ route('subcategory.create') }}" class="btn btn-primary mb-3">Add New Subcategory</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Group</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
                <tr>
                    <td>{{ $subcategory->id }}</td>
                    <td>{{ $subcategory->groupid }}</td>
                    <td>{{ $subcategory->categoryid }}</td>
                    <td>{{ $subcategory->subcategory }}</td>
                    <td>
                        <a href="{{ route('subcategory.update', $subcategory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('subcategory.delete', $subcategory->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
