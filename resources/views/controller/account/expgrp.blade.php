@extends('controller.account.Alayout')
@section('title', 'Expenses')
@section('Dashboard_select', 'active')
@section('container')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- SweetAlert2 -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        thead {
            background-color: black;
            color: white;
        }

        th,
        td {
            text-align: center;
        }

        .btn-edit,
        .btn-delete {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Expenses Group Details</h1>
            <a href="{{ url('controller/exp/create') }}">
                <button class="btn btn-primary">Create</button>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr id="expense-{{ $expense->id }}"> 
                        <td>{{ $expense->Group }}</td>
                       
                        <td>
                            <button class="btn btn-warning btn-edit" data-id="{{ $expense->id }}"
                                data-group="{{ $expense->Group }}"
                               >Edit</button>
                            <button class="btn btn-danger btn-delete" data-id="{{ $expense->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editGroup">Group</label>
                            <input type="text" class="form-control" id="editGroup" name="group_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX for Edit and Delete -->
    <script>
        $(document).ready(function() {
            // Handle edit button click
            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const group = $(this).data('group');
                const category = $(this).data('category');
                
                // Set values in the modal
                $('#editId').val(id);
                $('#editGroup').val(group);
                $('#editCategory').val(category);

                // Show the modal
                $('#editModal').modal('show');
            });

            // Handle edit form submission with AJAX
            $('#editForm').on('submit', function(event) {
                event.preventDefault();

                const id = $('#editId').val();
                const formData = {
                    group_name: $('#editGroup').val(),
                    category_name: $('#editCategory').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: `/expenses/${id}`, // Ensure this route is correct in your web.php file
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        // Update the content of the corresponding row
                        $(`#expense-${id} td:nth-child(1)`).text(formData.group_name);
                        $(`#expense-${id} td:nth-child(2)`).text(formData.category_name);

                        // Hide the modal
                        $('#editModal').modal('hide');

                        // Show success message with Swal
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: 'Expense updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Handle delete button click with AJAX
            $('.btn-delete').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/expenses/${id}`, // Ensure this matches your delete route
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(response) {
                                // Remove the row from the table
                                $(`#expense-${id}`).remove();

                                // Show success message with Swal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Expense deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                alert('Error: ' + xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>

@endsection
