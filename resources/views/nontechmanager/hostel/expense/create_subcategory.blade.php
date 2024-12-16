@extends('nontechmanager/hostel/layout')

@section('container')
<div class="container">
    <h2>Create New Subcategory</h2>
    <a href="{{ route('subcategory.index') }}" class="btn btn-secondary mb-3">Back to Subcategories</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subcategory.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="aid" class="form-label">Admin ID</label>
            <input type="number" class="form-control" id="aid" name="aid" required>
        </div>
        <div class="mb-3">
            <label for="nontechmanagerid" class="form-label">Non-Tech Manager ID</label>
            <input type="number" class="form-control" id="nontechmanagerid" name="nontechmanagerid" required>
        </div>
        <div class="mb-3">
            <label for="groupid" class="form-label">Group</label>
            <select class="form-select" id="groupid" name="groupid" required>
                <option value="" selected disabled>Select Group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="categoryid" class="form-label">Category</label>
            <select class="form-select" id="categoryid" name="categoryid" required>
                <option value="" selected disabled>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="subcategory" class="form-label">Subcategory</label>
            <input type="text" class="form-control" id="subcategory" name="subcategory" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Subcategory</button>
    </form>
</div>
@endsection
