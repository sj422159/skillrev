@extends('controller/academ/layout')
@section('title','Add Subject')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <form action="{{url('academic_controller/domain/savedomain')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="jobskill">Education</label>
                            <select id="mainbranch" name="groupid" class="form-control" required="true">
                                <option value="">Select</option>
                                @foreach($groups as $list)
                                    <option value="{{$list->id}}" data-gtype="{{$list->gtype}}" {{ $groupid == $list->id ? 'selected' : '' }}>{{$list->group}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="branchname">Specialisation</label>
                            <select name="category" class="form-control" required="true" id="subbranch">
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="jobskill">Subject Type</label>
                            <select id="subject_type" name="stype" class="form-control" required="true">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-3 mt-2 mt-sm-0">
                            <label for="jobrole">Subject</label>
                            <input type="text" class="form-control" id="jobrole" placeholder="Enter Subject" name="domain" value="{{$domain}}" required="true">
                        </div>

                        <div class="col-12 col-sm-3 mt-2 mt-sm-0">
                            <label for="jobrole">Visible Name</label>
                            <input type="text" class="form-control" id="jobrole" placeholder="Name For Students" name="dname" value="{{$dname}}" required="true">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-check mt-3" id="visibility_checkbox" style="display: none;">
                            <input type="checkbox" class="form-check-input" id="check1" name="show" style="margin-top:8px;margin-left:0px;" {{ $show == "1" ? 'checked' : '' }}>
                            <label class="form-check-label" for="show" style="margin-left:30px;text-transform:uppercase;"><b>Check If You Want it visible For Students ?</b></label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{$id}}">
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    // Store initial values
    var groupID = '{{$groupid}}';
    var selectedCategoryID = '{{$category}}';
    var selectedSubType = '{{$subtype}}';

    // Function to handle checkbox visibility
    function handleCheckboxVisibility(gtype) {
        if(gtype == 2) {
            $('#visibility_checkbox').show();
        } else {
            $('#visibility_checkbox').hide();
            $('#check1').prop('checked', false); // Uncheck the checkbox when hidden
        }
    }

    // Handle initial checkbox visibility
    if(groupID) {
        var initialGtype = $('#mainbranch option:selected').data('gtype');
        handleCheckboxVisibility(initialGtype);
    }

    // If there's a group selected, fetch categories and subject types
    if(groupID) {
        fetchCategories(groupID, selectedCategoryID);
        fetchSubjectTypes(groupID, selectedSubType);
    }

    // Handle group change
    $('#mainbranch').change(function(){
        var groupID = $(this).val();
        var gtype = $(this).find('option:selected').data('gtype');
        
        handleCheckboxVisibility(gtype);
        fetchCategories(groupID);
        fetchSubjectTypes(groupID);
    });

    function fetchCategories(groupID, selectedCategoryID = '') {
        $('#subbranch').html('<option value="">Select</option>');
        if(groupID) {
            $.ajax({
                url: '{{url("academic_controller/skillset/getcategory/{id}")}}',
                type: 'GET',
                data: { myID: groupID },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, category) {
                        var isSelected = (selectedCategoryID == category.id) ? 'selected' : '';
                        $('#subbranch').append('<option value="'+category.id+'" '+isSelected+'>' + category.categories + '</option>');
                    });
                }
            });
        }
    }

    function fetchSubjectTypes(groupID, selectedSubType = '') {
        $('#subject_type').html('<option value="">Select</option>');
        if(groupID) {
            $.ajax({
                url: '{{url("academic_controller/skillset/getsubjecttypes/{id}")}}',
                type: 'GET',
                data: { myID: groupID },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, subjectType) {
                        var isSelected = (selectedSubType == subjectType.type) ? 'selected' : '';
                        $('#subject_type').append('<option value="'+subjectType.type+'" '+isSelected+'>' + subjectType.type + '</option>');
                    });
                }
            });
        }
    }
});
</script>
@endsection