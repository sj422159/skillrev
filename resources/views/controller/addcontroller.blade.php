@extends('admin.layout') <!-- Updated to match your folder structure -->
@section('title', 'Add') <!-- Set the page title -->
@section('Dashboard_select', 'active') <!-- Activate the corresponding nav item -->
@section('container') <!-- Begin container section -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa; /* Light background for the body */
        }
        thead {
            background-color: black; /* Table background */
            color: white; /* Table text color */
        }
        th, td {
            text-align: center; /* Center text in table cells */
        }
        .btn-edit, .btn-delete {
            margin: 0 5px; /* Space between buttons */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }
            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Controller Details</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create</button>
        </div>

        <!-- Responsive Table to display controller data -->
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Actions</th> <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($controllers as $controller)
                        <tr>
                            <td>{{ $controller->name }}</td>
                            <td>{{ $controller->role }}</td>
                            <td>{{ $controller->email }}</td>
                            <td>{{ $controller->number }}</td>
                            <td>
                                <button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editModal" data-id="{{ $controller->id }}" data-name="{{ $controller->name }}" data-role="{{ $controller->role }}" data-email="{{ $controller->email }}" data-number="{{ $controller->number }}">Edit</button>
                                <button class="btn btn-danger btn-delete" data-id="{{ $controller->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Responsive modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Controller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="number">Mobile Number:</label>
                            <input type="text" class="form-control" name="number" id="number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Responsive modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Controller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        @csrf
                        <input type="hidden" name="id" id="editId">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role:</label>
                            <select class="form-control" name="role" id="editRole" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="editNumber">Mobile Number:</label>
                            <input type="text" class="form-control" name="number" id="editNumber" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // AJAX for creating a new controller
        $('#createForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('controller.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Fill edit modal with current data
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var role = $(this).data('role');
            var email = $(this).data('email');
            var number = $(this).data('number');

            $('#editId').val(id);
            $('#editName').val(name);
            $('#editRole').val(role);
            $('#editEmail').val(email);
            $('#editNumber').val(number);
        });

        // AJAX for updating a controller
        $('#editForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('controller.update') }}', // Define this route in web.php
                type: 'PUT', // Use PUT for updating
                data: $(this).serialize(),
                success: function(response) {
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // AJAX for deleting a controller
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this controller?')) {
                $.ajax({
                    url: '{{ route('controller.destroy', '') }}/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>

@endsection
