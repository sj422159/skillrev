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
            <a href="{{url('admin/addcontroller')}}"> <button class="btn btn-primary">Create</button></a>
        </div>

        <!-- Responsive Table to display controller data -->
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Actions</th> <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($controllers as $controller)
                        <tr>
                            <td>{{ $controller->name }}</td>
                            <td>{{ $controller->email }}</td>
                            <td>{{ $controller->number }}</td>
                            <td>
                                <button class="btn btn-warning btn-edit" 
        data-toggle="modal" 
        data-target="#editModal" 
        data-id="{{ $controller->id }}" 
        data-name="{{ $controller->name }}" 
        data-role="{{ $controller->role_id }}" 
        data-email="{{ $controller->email }}" 
        data-number="{{ $controller->number }}">
    Edit
</button>

                                <button class="btn btn-danger btn-delete" data-id="{{ $controller->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<script>
$(document).on('click', '.btn-edit', function () {
    // Get the data attributes
    const id = $(this).data('id');
    const name = $(this).data('name');
    const role = $(this).data('role');
    const email = $(this).data('email');
    const number = $(this).data('number');

    // Build the URL with query parameters
    const url = `/admin/addcontroller?id=${id}&name=${encodeURIComponent(name)}&role=${role}&email=${encodeURIComponent(email)}&number=${number}`;

    // Redirect to the URL
    window.location.href = url;
});



    // Handle the form submission for updates
    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("controller.update") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
    $('.btn-delete').on('click', function() {
                var id = $(this).data('id');
                
                if (confirm("Are you sure you want to delete this controller?")) {
                    $.ajax({
                        url: '{{ route('controller.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                }
            });
</script>
</body>
</html>

@endsection
