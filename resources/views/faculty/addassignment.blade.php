@extends('faculty/layout')
@section('title','Assign')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Assign To Student</h3>
            </div>
            <form action="{{url('faculty/assignment/assign/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Class</label>
                        <select id="subbranch" name="class" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                        <option value="">Select</option>
                        @foreach($classes as $list)
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                        @endforeach
                        </select> 
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="GenderId" class="form-control-label">Section</label>
                        <select id="childbranch" name="section" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                        <option value="">Select</option>
                        </select>        
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Training</label>
                        <select id="mainbranch" name="assignationid" type="text" class="form-control" required="true" multiselect-search="true" multiselect-select-all="true">
                            <option value="">Select</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="jobrole">Assignment Name </label>
                        <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter" name="assignmentname">
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="jobskill">Upload File</label>
                        <input type="file" class="form-control" name="file" accept="application/*" required="true">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="{{asset('assets/js/multiselect-dropdown.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$('#subbranch').change(function(){
var state = $('#subbranch').val();
$('#childbranch').html('');
$.ajax({
url:'{{url("faculty/getsection/byassignationid/{id}")}}',
type:'GET',
data:{myID:state},
dataType: "json",
success:function(data){
$('#childbranch').prop('disabled', false).append('<option value="">Select</option>'); 
$.each(data, function(key,subranches){     
$('#childbranch').prop('disabled', false).append('<option value="'+subranches.id+'">'+subranches.section+'</option>');
});
}
});
});


$('#childbranch').change(function(){
var sec = $('#childbranch').val();
var cl = $('#subbranch').val();
$('#mainbranch').html('');
$.ajax({
url:'{{url("faculty/gettraining/byassignationid/{id}")}}',
type:'GET',
data:{sec:sec,cl:cl},
dataType: "json",
success:function(data){
$('#mainbranch').prop('disabled', false).append('<option value="">Select</option>'); 
$.each(data, function(key,subranches){     
$('#mainbranch').prop('disabled', false).append('<option value="'+subranches.id+'">'+subranches.trainingname+'</option>');
});
}
});
});

});
</script>
@endsection