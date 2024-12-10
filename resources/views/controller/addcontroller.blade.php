@extends('admin.layout') 
@section('title', 'Add Controller') 
@section('Dashboard_select', 'active')
@section('container') 

<div style="background-color: #007BFF;  padding: 10px;">
    <h2 style="margin: 0; text-align: left;color: white;">Add Controller</h2>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="createForm" method="POST" action="{{ $controller ?  url('admin/updatecontroller')  : url('admin/savecontroller') }}">
                @csrf
                @if($controller)
                <input type="hidden" name="id" value="{{ $controller->id }}">
                @endif
                <input type="hidden" name="aid" value="{{ session()->get('ADMIN_ID') }}"> 

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" 
                                   value="{{ $controller->name ?? '' }}" required> <!-- Pre-fill name if editing -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" name="Controller_role_ID" id="role" required onchange="updateRoleId()">
                                <option value="">Select a role</option>
                                @foreach($role_name as $role)
                                <option value="{{ $role->id }}" {{ (isset($controller) && $controller->Controller_role_ID == $role->id) ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="role_id" id="role_id" value="{{ $controller->Controller_role_ID ?? '' }}"> <!-- Hidden role_id field -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                   value="{{ $controller->email ?? '' }}" required> <!-- Pre-fill email if editing -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="number">Mobile Number:</label>
                            <input type="text" class="form-control" name="number" id="number" 
                                   value="{{ $controller->number ?? '' }}" required> <!-- Pre-fill number if editing -->
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateRoleId() {
        const roleSelect = document.getElementById('role');
        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        const roleId = selectedOption.value;
        document.getElementById('role_id').value = roleId || ''; // Set role_id hidden field
    }
</script>

@endsection
