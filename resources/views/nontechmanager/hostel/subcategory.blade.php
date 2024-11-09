@extends('nontechmanager.hostel.layout')
<style>
    /* Prevent text wrapping inside the table cells */
.table td, .table th {
    white-space: nowrap;
}

/* Optionally, you can increase the width of the columns */
.table th, .table td {
    width: 200px; /* Adjust width as needed */
}

</style>
@section('container')

<div class="container">
    <h1 class="mb-4">Expenses</h1>

    <!-- Create Button Aligned Right -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ url('nontech/manager/hostel/expense/subcategory/create') }}" class="btn btn-primary" style="background-color: blue; color: white;">
            Create
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: black; color: white;">
                    <th>Groups</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->group }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ $expense->subcategory }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-success btn-sm editBtn" 
                            data-id="{{$expense->id }}"
                            data-group="{{$expense->group }}"
                            data-category="{{$expense->category }}"
                            data-subcategory="{{$expense->subcategory }}">
                            Edit
                        </button>
                        
                        <!-- Delete Button -->
                        <form action="{{ url('nontech/manager/hostel/expense/subcategory/delete', $expense->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="color: white;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ url('nontech/manager/hostel/expense/subcategory/update') }}">
                    @csrf
                    @method('PUT') <!-- Specify the PUT method for updating -->

                    <input type="hidden" name="id" id="subcategoryId"> <!-- Hidden ID field for update -->

                    <!-- Group Dropdown -->
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select class="form-select" name="group" id="editGroup" required>
                            <option value="">Select Group</option>
                            @foreach($expenses as $expense)
                                <option value="{{ $expense->group }}" {{ old('group') == $expense->group ? 'selected' : '' }}>
                                    {{ $expense->group }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" name="category" id="editCategory" required>
                            <option value="">Select Category</option>
                            @foreach($expenses as $expense)
                                <option value="{{ $expense->category }}" {{ old('category') == $expense->category ? 'selected' : '' }}>
                                    {{ $expense->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subcategory Name Input -->
                    <div class="mb-3">
                        <label for="subcategory" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" name="subcategory" id="editSubcategory" placeholder="Enter subcategory name" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Check if a success message is present in the session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif


        $('.editBtn').on('click', function () {
            var id = $(this).data('id');
            var group = $(this).data('group');
            var category = $(this).data('category');
            var subcategory = $(this).data('subcategory');
            
            // Populate the modal fields
            $('#subcategoryId').val(id);
            $('#editGroup').val(group);
            $('#editCategory').val(category);
            $('#editSubcategory').val(subcategory);
            
            // Show the modal
            $('#editModal').modal('show');
        });
    });
</script>

@endsection
