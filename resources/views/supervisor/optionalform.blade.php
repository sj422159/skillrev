@extends('supervisor/layout')
@section('title','Subject Utilization')
@section('d','active')
@section('container')

<style type="text/css">
    h6{
        text-align: center !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">GROUP MANAGER SCHEDULE CLASS</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('groupmanager/optional/schedule/day')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Subject Name</label>
                    <input type="text" class="form-control" id="subject" required="true"  name="name" value="{{$name}}" readonly>
                </div>
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="class"  id="clasy" required="true" required onchange="secm(this)" readonly>
                <option value="">Select Class</option>
                 @foreach($class as $list)
                 @if($cl==$list->id)
                 <option value="{{$list->id}}" selected>{{$list->categories}}</option>
                 @else
                 <option value="{{$list->id}}">{{$list->categories}}</option>
                 @endif
                 @endforeach
               
                </select>
                </div>
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Students</label>
                 <input type="text" class="form-control" id="students" required="true"  name="total" value="{{$finalcount}}" readonly>
                </div>
               
             
                
              </div>
              <div class="form-row mt-3">
                  @foreach($skills as $list)
                     <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">{{$list->skillset}}</label>
                 <input type="text" class="form-control" id="students" required="true"  name="total" value="{{$list->stucount}}" readonly>
                </div>
                  @endforeach


              </div>


              <div class="form-row mt-4"> 
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Type Class</label>
                <select class="multisteps-form__select form-control" name="type"  id="type" required="true" required >
                <option value="">Select Type</option>
                          @foreach($classtypes as $list)
                          @if($type==$list->id)
                            <option selected value="{{$list->id}}">{{$list->classtype}}</option>
                          @else
                             <option  value="{{$list->id}}">{{$list->classtype}}</option>
                          @endif
                          @endforeach
                </select>
                </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Day</label>
                     <select name="day" class="form-control" id="day" required="true" data-val="" onchange="per(this)">
                     <option value="" >Select Day</option>
                     @foreach($days as $list)
                      <option  value="{{$list}}">{{$list}}</option>
                     @endforeach
                </select>
                  </div>
                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Period</label>
                   <select name="Period" class="form-control" id="period" required="true" data-val="" onchange="data(this)">     
                   </select>
                  </div>
                 
              </div>
                  @foreach($skills as $list)
                <div class="form-row mt-4">

                 @if($list->stucount==0)
                       <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Subject</label>
                 <input type="text" class="form-control" id="students"   name="total" value="{{$list->skillset}}" readonly>
                </div>
                     
                      <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Faculty</label>
                <select class="multisteps-form__select form-control facs" name="faculties[]"  id="facs">
               
                </select>
                </div>

                  <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Select Rooms</label>
                <select class="multisteps-form__select form-control rooms" name="rooms[]"  id="rooms" >        
                </select>
               
                </div>
                 @else
                      <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Subject</label>
                 <input type="text" class="form-control" id="students" required="true"  name="total" value="{{$list->skillset}}" readonly>
                </div>
                     
                      <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Faculty</label>
                <select class="multisteps-form__select form-control facs" name="faculties[]"  id="facs" required="true" required  >
               
                </select>
                </div>

                  <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Select Rooms</label>
                <select class="multisteps-form__select form-control rooms" name="rooms[]"  id="rooms" required="true" required>        
                </select>
               
                </div>
                 @endif

                  
                 </div>
                 <input type="hidden" name="module[]" value="{{$list->id}}">
                 @endforeach
                 
                  <div class="form-row mt-4" id="in">
             
                 </div>

                    <h6 id="asstxt" style="color:red;text-align: center;"></h6>
                	
              
               
            
                  
                   <div class="form-row mt-4">
                 


                  
                  

                  </div>
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="rowid" value="{{$rowid}}">
         
                    <input type="hidden" name="sid" value="{{$sid}}">
                </div>
                <div class="card-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="ass">Assign</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script type="text/javascript">
   var count=0;
       
   var stu=document.getElementById("students").value;
	
	

    function per(that){
         var peri=0;
        
            var val=document.getElementById('day').value;
            clas=document.getElementById('clasy').value;
             $('#period').html('');
             $.ajax({
              url:'{{url("groupmanager/optional/getperiod/")}}',
              type:'GET',
              data:{cl:clas,val:val},
              dataType: "json",
              success:function(data)
              {
                         var k=data[0];
                          $('#period').prop('disabled', false).append('<option value="">Select Period</option>');
                        for (var i =1; i <= k; i++) {
                          if(data[1].includes(i.toString())){

                          }else{

                            $('#period').prop('disabled', false).append('<option value="'+i+'">'+i+'</option>');
                          }
                            
                        }  
                        if(parseInt(data[2])==parseInt(data[3])){
                           $('#period').html('');
                          $('#period').prop('disabled', false).append('<option value="">No Periods</option>');
                        }
              }
          });




    }

    function data(that){
       
        var peri=that.value;
        var sub=<?php echo $sid;?>;
            var val=document.getElementById('day').value;
            clas=document.getElementById('clasy').value;
             $('.facs').html('');
              $('.rooms').html('');

             $.ajax({
              url:'{{url("groupmanager/optional/getfaculty/")}}',
              type:'GET',
              data:{cl:clas,val:val,per:peri,sub:sub},
              dataType: "json",
              success:function(data)
              {

                           $('.facs').prop('disabled', false).append('<option value="">Select</option>');
                          for(var i=0;i<data[2].length;i++){
                            if(data[3].includes(data[2][i]['id'].toString())){

                            }else{
                            $('.facs').prop('disabled', false).append('<option value="'+data[2][i]['id']+'**FACULTY">'+data[2][i]['fname']+'</option>');
                             }
                        }
                            for(var i=0;i<data[0].length;i++){
                            if(data[1].includes(data[0][i]['id'].toString())){

                            }else{
                            $('.facs').prop('disabled', false).append('<option value="'+data[0][i]['id']+'**MANAGER">'+data[0][i]['mname']+'</option>');
                             }
                        }

                         for(var i=0;i<data[4].length;i++){
                            if(data[5].includes(data[4][i]['id'].toString())){

                            }else{
                            $('.facs').prop('disabled', false).append('<option value="'+data[4][i]['id']+'**GROUPMANAGER">'+data[4][i]['supname']+'</option>');
                             }
                        }
                         $('.rooms').prop('disabled', false).append('<option value="">Select</option>');
                        for(var i=0;i<data[6].length;i++){
                            if(data[7].includes(data[6][i]['id'].toString())){

                            }else{
                            $('.rooms').prop('disabled', false).append('<option value="'+data[6][i]['id']+'**SECTION"> SEC '+data[6][i]['section']+'</option>');
                             }
                        }

                        for(var i=0;i<data[8].length;i++){
                            if(data[9].includes(data[8][i]['id'].toString())){

                            }else{
                            $('.rooms').prop('disabled', false).append('<option value="'+data[8][i]['id']+'**ROOM">'+data[8][i]['roomname']+'</option>');
                             }
                        }
                        

                         
              }
          }); 
    }



   
</script>
@endsection