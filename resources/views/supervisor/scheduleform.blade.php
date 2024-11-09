@extends('supervisor/layout')
@section('title','Schedule')
@section('d','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;"> FACULTY SCHEDULE CLASS</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('groupmanager/schedule/day')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true"  name="name" value="{{$name}}" readonly>
                </div>
                <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Role</label>
                    <input type="text" readonly class="form-control" id="jobrole" required="true"  name="role" value="{{$role}}">
                </div>
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
              </div>
                <div class="form-row mt-4">
                <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="class"  id="clasy" required="true" required onchange="secm(this)">
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
                <label for="GenderId" class="form-control-label">Section</label>
                <select name="section" class="form-control" required="true" data-val="" id="section">
                
                </select>
                </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Day</label>
                     <select name="day" class="form-control" id="day" required="true" data-val="" onchange="per(this)">
                     <option value="" >Select Day</option>
                	 @foreach($days as $list)
                    @if($day==$list)
                       <option selected value="{{$list}}">{{$list}}</option>
                    @else
                      <option  value="{{$list}}">{{$list}}</option>
                    @endif
                     @endforeach
                </select>
                  </div>
                </div>
                   <div class="form-row mt-4">
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Period</label>
                   <select name="Period" class="form-control" id="period" required="true" data-val="">     
                   </select>
                  </div>

                 <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Subject</label>
                     <select name="Subject" class="form-control" required="true" data-val="" id="subject" onchange="getm(this)">
                    </select>
                  </div>

                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Module</label>
                     <select name="module[]" class="form-control" multiple required="true" data-val="" id="modules" >
                    </select>
                  </div>

                  

                  </div>
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="rowid" value="{{$rowid}}">
                </div>
                <div class="card-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="assign">Assign</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



 <script type="text/javascript">

 var id=<?php echo $id;?>;
 var clas=0;
  function per(that){
  	var clas=document.getElementById('clasy').value;
    var sec=document.getElementById('section').value;
    var val=that.value;
    var subjectt=[];
    
    $('#period').html('');
     $('#subject').html('');
      $.ajax({
              url:'{{url("supervisor/getperiod/")}}',
              type:'GET',
              data:{cl:clas,val:val,id:id,sec:sec},
              dataType: "json",
              success:function(data)
              {
                      console.log(data);
                  
                        var k=data[4];
                       
                        for (var i =1; i <= k; i++) {
                          if(data[1].includes(i.toString())){

                          }else{
                            $('#period').prop('disabled', false).append('<option value="'+i+'">'+i+'</option>');
                          }
                        	
                        }  
                         $('#assign').attr("disabled",false);
                        if(parseInt(data[0])==parseInt(data[3])){
                           $('#period').html('');
                          $('#period').prop('disabled', false).append('<option value="">No Periods</option>');
                           $('#assign').attr("disabled",true);
                        }
                        if(parseInt(data[2])==1){
                           $('#period').html('');
                          $('#period').prop('disabled', false).append('<option value="">Faculty Occupied</option>');
                           $('#assign').attr("disabled",true);
                        }

                        if(parseInt(data[2])==2){
                           $('#period').html('');
                          $('#period').prop('disabled', false).append('<option value="">Optional Notscheduled</option>');
                           $('#assign').attr("disabled",true);
                        }
                
              }
          });
     
       $.ajax({
              url:'{{url("supervisor/getsubject/")}}',
              type:'GET',
              data:{cl:clas,val:val,id:id},
              dataType: "json",
              success:function(data)
              {
                
               $('#subject').prop('disabled', false).append('<option value="">Select Subject</option>');  
                $.each(data, function(key,subject)
                 { 
                  
                     
                	$('#subject').prop('disabled', false).append('<option value="'+subject.id+'">'+subject.domain+'</option>');
                       
                });
                

              }
          });
        
      
  	 
  }
      

     function getm(that){
       clas=document.getElementById('clasy').value;
       var subs=that.value;
        $('#modules').html('');
       $.ajax({
              url:'{{url("supervisor/getmodule/")}}',
              type:'GET',
              data:{cl:clas,sub:subs,id:id},
              dataType: "json",
              success:function(data)
              {
                $.each(data, function(key,modules)
                 {   
                  $('#modules').prop('disabled', false).append('<option value="'+modules.id+'" selected>'+modules.skillset+'</option>');
                       
                });

              }
          });
     }



        function secm(that){
          var classid = that.value;
          clas=that.value;
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });
         }




          $(document).ready(function(){
           var classid = document.getElementById('clasy').value; 
          var sectionid=$('#class').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("supervisor/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,section)
                 {   
                   if(sectionid==section.id){
                       $('#section').prop('disabled', false).append('<option value="'+section.id+'" selected >'+section.section+'</option>');
                   }else{
                        $('#section').prop('disabled', false).append('<option value="'+section.id+'">'+section.section+'</option>');
                   }
                });
              }
          });

          });

           $(document).ready(function(){

            var peri=<?php echo $peri;?>;
            var val=document.getElementById('day').value;
            clas=document.getElementById('clasy').value;
             sectionid=document.getElementById('section').value;
           
             $.ajax({
              url:'{{url("supervisor/getperiod/")}}',
              type:'GET',
              data:{cl:clas,val:val,sec:sectionid,id:id},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,period)
                 {   
                        var k=period[0];
                        for (var i =1; i <= k; i++) {
                          if(peri==i){
                            $('#period').prop('disabled', false).append('<option value="'+i+'" selected>'+i+'</option>');
                          }else{
                            $('#period').prop('disabled', false).append('<option value="'+i+'">'+i+'</option>');
                          }
                          
                        }  
                }); 
              }
          });

          var subii=<?php echo $subii ?>;
           $.ajax({
              url:'{{url("supervisor/getsubject/")}}',
              type:'GET',
              data:{cl:clas,val:val,id:id},
              dataType: "json",
              success:function(data)
              {
                
               $('#subject').prop('disabled', false).append('<option value="">Select Subject</option>');  
                $.each(data, function(key,subject)
                 { 
                  
                  if(subii==subject.id){
                     $('#subject').prop('disabled', false).append('<option value="'+subject.id+'" selected>'+subject.domain+'</option>');
                  } else{
                     $('#subject').prop('disabled', false).append('<option value="'+subject.id+'">'+subject.domain+'</option>');
                  }
                 
                       
                });
                

              }

          });
            getmodf(subii);

          
        






           });



           function getmodf(subii){

             clas=document.getElementById('clasy').value;
           var subj=subii;
           var modi= <?php echo json_encode($modi); ?>;
       $.ajax({
              url:'{{url("supervisor/getmodule/")}}',
              type:'GET',
              data:{cl:clas,sub:subj,id:id},
              dataType: "json",
              success:function(data)
              {
                $.each(data, function(key,modules)
                 {   
                  if(modi.includes((modules.id).toString())){
                    $('#modules').prop('disabled', false).append('<option value="'+modules.id+'" selected>'+modules.skillset+'</option>');
                  }else{
                     $('#modules').prop('disabled', false).append('<option value="'+modules.id+'" >'+modules.skillset+'</option>');
                  }
                 
                       
                });

              }
          });
           }


       
       
    </script>

@endsection