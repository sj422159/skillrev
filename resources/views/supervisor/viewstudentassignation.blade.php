@extends('supervisor/layout')
@section('title','Assignations')
@section('Dashboard_select','active')
@section('container')
<style type="text/css">
  h3{
    font-weight: 400;
  }
</style>
<div class="col-12" style="padding:10px;">
<div class="card">
  <div class="card-header bg-primary">
    <h3 class="card-title text-white">Assignations</h3>
  </div>
<div class="card-body">
<form action="{{url('supervisor/student/assignations/save')}}" method="post"> 
@csrf
<div>
<h3 style="color: red;margin-bottom:10px !important;">Important Instructions For Assignation Of Assesment :</h3>
<p><b>Step 1 : </b> Remove the student which you do not need for writing the assesment.</p>


</div>
<table id="simpleTable1" class="table table-bordered table-striped" style="margin-top:20px !important;">
  <thead>
    <tr>
    <th>ID</th>
    <th>Student</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @php
    $s=1;
    @endphp
    @foreach($student as $list)
    <tr>
    <td>{{$s}}</td>
    <td>{{$list->sname}}</td>
    <input type="hidden" name="studentassignationid" value="{{$studentassignationid}}">
    <input type="hidden" name="studentid[]" value="{{$list->id}}">
    <td>
    <div class="row" style="display:flex;">
    <div class="col-12 col-sm-3 mt-sm-0">
    <button type="button" class="btn-sm btn btn-danger r" style="margin-right:50px !important;">Unassign</button>
    </div>
    </div>
    </td>
    </tr>
    @php
     $s++;
    @endphp
    @endforeach 
    </tbody>
</table>
<div class="row" style="display:flex;justify-content: flex-end;">

  @if(count($preassesment)>0)
  <div class="col-12 col-sm-3 mt-sm-0">
    <select class="form-control mt-4" required name="preapp">
      <option value="">Please Approve Pre</option>
      <option value="1">Pre Approved</option>
      <option value="0">Pre Not Approved</option>
    </select>
  </div>
  <input type="hidden" name="preass" value="{{$preassesment[0]->id}}">
  @else
    <div class="col-12 col-sm-3 mt-sm-0">
    <select class="form-control mt-4" disabled required name="preapp" >
      <option value="">Please Approve Pre</option>
      <option value="1">Pre Approved</option>
      <option value="0" selected>Pre Not Approved</option>
    </select>
  </div>
  <input type="hidden" name="preass" value="0">
  @endif


    

<div class="col-12 col-sm-3 mt-sm-0">
  @if(count($postassesment)>0)

  <input type="hidden" name="postass" value="{{$postassesment[0]->id}}">
 
  <button type="submit" class="btn-sm btn btn-primary mt-4 a">Approve</button>
  @else
  <button type="button" class="btn-sm btn btn-danger mt-4" onclick="myFunction1()">Post Not Available</button>
  @endif
</div>
</div>
</form> 
</div>
</div>
</div>
@php
$studentcount=count($student);   
@endphp
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
var s="{{$studentcount}}";
function myFunction1(){
  swal({
      title:"Not Available",
      text: "We regret to inform you that you cannot proceed furthur since pre assesment for this training program has not defined by the admin !!",
      icon: "error",
      });
}
$('table').on('click', 'button', function(e){
  $(this).closest('tr').remove()
  s=s-1;
  if(s==0){
    $(".a").prop('disabled', true);
  }
});
</script>       
@endsection