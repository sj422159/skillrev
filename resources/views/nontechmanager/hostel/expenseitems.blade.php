@extends('nontechmanager.hostel.layout')

@section('container')
<div class="container">
    <h1 class="mb-4">Expense Items</h1>

    <!-- Create Button Aligned Right -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ url('nontech/manager/hostel/expense/item/create') }}" class="btn btn-primary" style="background-color: blue; color: white;">
            Create
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: black; color: white;">
                    <th>Group</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Items</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenseItems as $item)
                <tr>
                    <td>{{ $item->group }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->subcategory }}</td>
                    <td>{{ $item->items }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-success btn-sm editBtn" 
                            data-id="{{ $item->id }}"
                            data-group="{{ $item->group }}"
                            data-category="{{ $item->category }}"
                            data-subcategory="{{ $item->subcategory }}"
                            data-items="{{ $item->items }}">
                            Edit
                        </button>
                        
                        <!-- Delete Button -->
                        <form action="{{ url('nontech/manager/hostel/expense/item/delete', $item->id) }}" method="POST" style="display: inline;">
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

<!-- Modal for Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Expense Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ url('nontech/manager/hostel/expense/item/update') }}">
                    @csrf
                    @method('PUT') <!-- Specify the PUT method for updating -->

                    <input type="hidden" name="id" id="itemId"> <!-- Hidden ID field for update -->

                    <!-- Group Dropdown -->
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select class="form-select" name="group" id="editGroup" required>
                            <option value="">Select Group</option>
                            @foreach($distinctGroups as $group)
                                <option value="{{ $group }}" {{ old('group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" name="category" id="editCategory" required>
                            <option value="">Select Category</option>
                            @foreach($distinctCategories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subcategory Dropdown -->
                    <div class="mb-3">
                        <label for="subcategory" class="form-label">Subcategory</label>
                        <select class="form-select" name="subcategory" id="editSubcategory" required>
                            <option value="">Select Subcategory</option>
                            @foreach($distinctSubcategories as $subcategory)
                                <option value="{{ $subcategory }}" {{ old('subcategory') == $subcategory ? 'selected' : '' }}>{{ $subcategory }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Item Name Input -->
                    <div class="mb-3">
                        <label for="items" class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="items" id="editItems" placeholder="Enter item name" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle edit button click
        $('.editBtn').on('click', function () {
            var id = $(this).data('id');
            var group = $(this).data('group');
            var category = $(this).data('category');
            var subcategory = $(this).data('subcategory');
            var items = $(this).data('items');
            
            // Populate the modal fields
            $('#itemId').val(id);
            $('#editGroup').val(group);
            $('#editCategory').val(category);
            $('#editSubcategory').val(subcategory);
            $('#editItems').val(items);
            
            // Show the modal
            $('#editModal').modal('show');
        });
    });
</script>

@endsection
