@extends('nontechmanager.hostel.layout')

@section('container')
<div class="container">
    <h1 class="mb-4">Create New Subcategory</h1>
    
    <form action="{{ url('nontech/manager/hostel/expense/subcategory/store') }}" method="POST">
        @csrf

        <!-- Group and Category in the Same Row -->
        <div class="row mb-3">
            <!-- Group Dropdown -->
            <div class="col-md-6">
                <label for="group" class="form-label">Group</label>
                <select class="form-select" name="group" id="group" required>
                    <option value="">Select Group</option>
                    @foreach($groups as $group)
                        <option value="{{ $group }}">{{ $group }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Dropdown -->
            <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Subcategory and Submit Button in the Same Row -->
        <div class="row mb-3">
            <!-- Subcategory Name Input -->
            <div class="col-md-8">
                <label for="subcategory" class="form-label">Subcategory Name</label>
                <input type="text" class="form-control" name="subcategory" id="subcategory" placeholder="Enter subcategory name" required>
            </div>

            <!-- Submit Button -->
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" style="background-color: blue; color: white;">
                    Create Subcategory
                </button>
            </div>
        </div>
    </form>
</div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 2000, // Optional: Time to show alert in milliseconds
            showConfirmButton: false
        }).then(() => {
            // Redirect to the subcategory page after alert
            window.location.href = "{{ url('nontech/manager/hostel/expense/subcategory') }}";
        });
    </script>
@endif

@endsection
