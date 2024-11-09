@extends('admin/layout')
@section('title','Add staff')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/nontech/staff/savestaff')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Group Manager Name</label>
                <select class="multisteps-form__select form-control" name="supid" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($nontechsupervisors as $list)
                @if($supid==$list->id){
                <option selected value="{{$list->id}}">{{$list->supname}}</option>
                }@else{
                <option  value="{{$list->id}}">{{$list->supname}}</option>
                }
                @endif
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Department</label>
                <select name="departmentid" class="form-control" required="true" data-val="{{$departmentid}}" id="subbranch">
                </select>
                </div>
            </div>
            <div class="form-row mt-4">
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Staff Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Staff Email Address</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>

                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Staff Mobile Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>
                </div>

                <input type="hidden" name="id" value="{{$id}}">
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
            var state = $('#mainbranch').val();
            var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/nontech/getdepartment/fromsupervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              { 
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.department+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.department+'</option>');
                   }
                });
              
              }
          });
          });

        $(document).ready(function(){
        $('#mainbranch').change(function(){
           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/nontech/getdepartment/fromsupervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              { 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.department+'</option>');
                });
              }
          }); 
        });
      });
</script>
@endsection