@extends('nontechmanager/hostel/layout')
@section('title','Room Details')
@section('Dashboard_select','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">BED REASSIGN</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('nontech/manager/hostel/bed/reassign/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">
                     <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                        <label for="role">Hostel :</label>
                         <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Room Name" name="room" value="{{$data[0]->hostel}}" readonly>
                    </div>
                   
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                        <label for="jobgroup">Room Name :</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Room Name" name="room" value="{{$data[0]->roomname}}" readonly>
                    </div>

                     <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                        <label for="jobgroup">Bed No :</label>
                        <input type="text" class="form-control"  required="true" placeholder="Enter Room Name" name="" value="{{$data[0]->itemno}}" readonly>
                    </div>
                </div>
                 <div class="form-row mt-2">
                      <div class="col-12  mt-2 mt-sm-0">
                      <label>ALLOCATED STUDENT :</label>
                        <input type="text" class="form-control"  placeholder="Enter Room Name" name="" value="{{$student}}" readonly>
                     </div>
                 </div>
                 <div class="form-row mt-2">
                     <div class="col-12 col-sm-6 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                       <label>CLASS :</label>
                        <select class="form-control" name="class" required id="topbranch">
                            <option value="">Select</option>
                            @foreach($class as $list)
                             <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endforeach
                        </select>
                     </div>
                   
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                      <label>SECTION :</label>
                         <select class="form-control" name="section" required id="mainbranch" >
                           <option value="">Select</option>
                         </select>
                     </div>
                     </div>
                     <div class="form-row mt-2">
                      <div class="col-12  mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                      <label>STUDENTS :</label>
                         <select class="form-control" name="student" required id="student">
                           <option value="">Select</option>
                         </select>
                     </div>
                 </div>

                
                    <input type="hidden" name="id" value="{{$data[0]->id}}">
                </div>
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script>
jQuery(document).ready(function(){
    jQuery('#topbranch').change(function (){
        let classid=document.getElementById("topbranch").value;
        jQuery.ajax({
            url:'{{url("nontech/manager/view/sections")}}',
            type:'get',
            data:{classid:classid},
            success:function(result){
            jQuery('#mainbranch').html(result)
            }
        });
    });
    jQuery('#mainbranch').change(function (){
        let classid=document.getElementById("mainbranch").value;
        jQuery.ajax({
            url:'{{url("nontech/manager/view/students")}}',
            type:'get',
            data:{classid:classid},
            success:function(result){
            jQuery('#student').html(result)
            }
        });
    });
});
</script>  
@endsection