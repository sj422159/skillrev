@extends('nontechmanager.hostel.layout')

@section('container')
<div class="container">
    <h1 class="mb-4">Create Expense Item</h1>

    <!-- Single Record Entry Form -->
    <form action="{{ url('nontech/manager/hostel/expense/item/store') }}" method="POST">
        @csrf

        <h3>Single Entry</h3>

        <!-- Group Dropdown -->
        <div class="mb-3">
            <label for="group" class="form-label">Group</label>
            <select class="form-select" name="group" id="group" required>
                <option value="">Select Group</option>
                @foreach($groups as $group)
                    <option value="{{ $group }}">{{ $group }}</option>
                @endforeach
            </select>
        </div>

        <!-- Category Dropdown -->
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category" id="category" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subcategory Dropdown -->
        <div class="mb-3">
            <label for="subcategory" class="form-label">Subcategory</label>
            <select class="form-select" name="subcategory" id="subcategory" required>
                <option value="">Select Subcategory</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory }}">{{ $subcategory }}</option>
                @endforeach
            </select>
        </div>

        <!-- Items Input -->
        <div class="mb-3">
            <label for="items" class="form-label">Item Name</label>
            <input type="text" class="form-control" name="items" id="items" placeholder="Enter item name" required>
        </div>

        <!-- Submit Button for Single Entry -->
        <button type="submit" class="btn btn-primary">Save Item</button>
    </form>

    <hr class="my-5">

    <!-- Bulk Upload Section -->
    <div>
        <h3>Bulk Upload</h3>
        <form action="{{ url('nontech/manager/hostel/expense/item/upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Download Template Button -->
            <a href="{{ url('nontech/manager/hostel/expense/item/template') }}" class="btn btn-info mb-3">Download Template</a>

            <!-- File Upload Input -->
            <div class="mb-3">
                <label for="excel_file" class="form-label">Upload CSV File</label>
                <input type="file" class="form-control" name="excel_file" id="excel_file" accept=".csv" required>
            </div>

            <!-- Submit Button for Bulk Upload -->
            <button type="submit" class="btn btn-success">Upload & Save Items</button>
        </form>
    </div>
</div>

@if(session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
@endif
@endsection
