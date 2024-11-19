@extends('controller/layout')
@section('title','Module')
@section('Dashboard_select','active')
@section('container')

<form action="{{url('admin/skillset/bydomain')}}" method="post" id="dynamicForm">
    @csrf
    <div class="form-row">
        <!-- Group Dropdown -->
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Group</label>
            <select class="form-control" name="group" id="group">
                <option value="">Select</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $groupid == $group->id ? 'selected' : '' }}>
                        {{ $group->group}}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Category Dropdown -->
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" name="category" id="category" data-val="{{ $categoryid }}">
                <option value="">Select</option>
            </select>
        </div>

        <!-- Domain Dropdown -->
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Subject</label>
            <select class="form-control" id="domain" name="domain" data-val="{{ old('domain') }}">
                <option value="">Select</option>
            </select>
        </div>

        <!-- Create Button -->
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
            <a href="{{url('admin/skillset/addskillset')}}">
                <button type="button" class="btn btn-primary" style="margin-top:8px;">Create</button>
            </a>
        </div>
    </div>
</form>


<!-- Table for Skillsets -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Module</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skillset as $list)
                        <tr>
                            <td>{{ $list->skillset }}</td>
                            <td>
                                {{-- <a href="{{ url('admin/skillset/updateskillset/' . $list->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i> Edit
                                </a>  --}}
                                <a href="{{ url('admin/skillset/' . $list->id) }}" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this skillset?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
jQuery(document).ready(function () {
    // Populate Categories when Group is selected
    jQuery('#group').change(function () {
        let groupId = jQuery(this).val();
        jQuery.ajax({
            url: '{{ url("admin/questionbank/getcategory") }}',
            type: 'GET',
            data: {
                cid: groupId,
                _token: '{{ csrf_token() }}'
            },
            success: function (result) {
                jQuery('#category').html(result);
            },
            error: function (err) {
                console.error('Error fetching categories:', err);
            }
        });
    });

    // Populate Domains when Category is selected
    jQuery('#category').change(function () {
        let categoryId = jQuery(this).val();
        let groupId = jQuery('#group').val();
        jQuery.ajax({
            url: '{{ url("admin/getdomains") }}',
            type: 'GET',
            data: {
                cid: categoryId,
                groupid: groupId
            },
            success: function (result) {
                jQuery('#domain').html(result);
            },
            error: function (err) {
                console.error('Error fetching domains:', err);
            }
        });
    });

    // Automatically submit form when Domain (Subject) is selected
    jQuery('#domain').change(function () {
        let selectedDomain = jQuery(this).val();
        if (selectedDomain) {
            // Trigger form submission
            jQuery('#dynamicForm').submit();
        }
    });
});

jQuery(document).ready(function() {
    jQuery('#group, #category, #domain').change(function() {
        let group = jQuery('#group').val();
        let category = jQuery('#category').val();
        let domain = jQuery('#domain').val();

        // Send an AJAX request to filter the data
        jQuery.ajax({
            url: '{{ url("admin/skillset/bydomain") }}',
            type: 'GET',
            data: {
                group: group,
                category: category,
                domain: domain,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Update the skillsets table dynamically
                jQuery('tbody').html(response);
            },
            error: function(err) {
                console.error('Error filtering data:', err);
            }
        });
    });
});

</script>

@endsection
