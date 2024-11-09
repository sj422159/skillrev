@extends('admin/layout')
@section('title','Add Manager')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Manager</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/manager/savemanager')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Group Manager Name</label>
                <select class="multisteps-form__select form-control" name="supid" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($supervisors as $list)
                @if($supid==$list->id){
                <option selected value="{{$list->id}}">{{$list->supname}}</option>
                }@else{
                <option  value="{{$list->id}}">{{$list->supname}}</option>
                }
                @endif
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Email</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>

                   <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>
               
                  
            </div>
            <div class="form-row mt-4">
                 <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class Manager</label>
                <select name="classid" class="form-control" required="true" data-val="{{$classid}}" id="monitoring">
                </select>
                </div>
                
                <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class Teaching</label>
                <select name="teachingclass[]" class="form-control" multiple required="true" id="subbranch">
                </select>
                </div>

                <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                    <label for="role">Subject</label>
                    <select id="sub" type="text" class="form-control" name="subject[]" multiple required="true" multiselect-search="true" multiselect-select-all="true" onchange="mod(this)">
                    </select>
                </div>
                <div class="col-12 col-sm-3 mt-4 mt-sm-0" >
                    <label for="mod">Modules</label>
                    <select id="module" type="text" class="form-control" name="module[]" multiple required="true" multiselect-search="true" multiselect-select-all="true" >
                       
                    </select>
                </div>
                  

                  

                  </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
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
                   var monitoring=$('#monitoring').attr('data-val');
                    var cls= <?php echo json_encode($teachingclasses); ?>;
                    cls=Object.values(cls);
                 //   alert(cls);
           $('#subbranch').html('');
            $('#monitoring').html('');
            $.ajax({
              url:'{{url("admin/manager/getclass/bygroupid/ofsupervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                $('#monitoring').prop('disabled', false).append('<option value="">Select</option>'); 
                $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                
                $.each(data, function(key,jobskills)
                 {   

                   if(monitoring==jobskills.id){
                       $('#monitoring').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.categories+'</option>');
                   }else{
                        $('#monitoring').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                   }
                   
                });

                
                $.each(data, function(key,jobskills)
                 { 
                 
                  if(cls.includes((jobskills.id).toString())){   
                    
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'" selected>'+jobskills.categories+'</option>');
                  }else{

                     $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
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
           $('#monitoring').html('');
            $.ajax({
              url:'{{url("admin/manager/getclass/bygroupid/ofsupervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                });
                $('#monitoring').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#monitoring').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                });
              }
          }); 
        });
      });





        $(document).ready(function(){
            

            var subbranch=$('#sub').attr('data-val');
            var sub= <?php echo json_encode($subjectid); ?>;
           sub=Object.values(sub);
           var state=<?php echo json_encode($teachingclasses); ?>;
          // alert(sub);
           $('#sub').html('');
            $.ajax({
              url:'{{url("admin/faculty/getsubject/from/multiple/classes/supervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
               $.each(data, function(key,subject){   

        if(sub.includes((subject.id).toString())){
        $('#sub').prop('disabled', false).append('<option value="'+subject.id+'" selected>'+subject.domain+'</option>');
        }else{
          $('#sub').prop('disabled', false).append('<option value="'+subject.id+'" >'+subject.domain+'</option>');   
        }
        });
              
              }
          });
          });
             
        $(document).ready(function(){
        $('#subbranch').change(function(){
           var state = $('#subbranch').val();
           var subbranch=$('#sub').attr('data-val');
           $('#sub').html('');
            $.ajax({
              url:'{{url("admin/faculty/getsubject/from/multiple/classes/supervisor/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
               $.each(data, function(key,subject){   
               $('#sub').prop('disabled', false).append('<option value="'+subject.id+'">'+subject.domain+'</option>');
               });
              }
          }); 
        });
      });



        function mod(that){
         $('#module').html('');
        var values = $('#sub').val();
            $.ajax({
        url:'{{url("admin/faculty/getmodule/{id}")}}',
        type:'GET',
        data:{myID:values},
        dataType: "json",
        success:function(data){
        $.each(data, function(key,modules){   
        console.log(modules);
       
        $('#module').prop('disabled', false).append('<option value="'+modules.id+'">'+modules.skillset+'</option>');
        
        });
        }
        });
        
    }

    
    $(document).ready(function(){
        var values = <?php echo json_encode($subjectid); ?>;
        var sel= <?php echo json_encode($module); ?>;
         sel=Object.values(sel);
         $.ajax({
        url:'{{url("admin/faculty/getmodule/{id}")}}',
        type:'GET',
        data:{myID:values},
        dataType: "json",
        success:function(data){
        $.each(data, function(key,modules){   
        if(sel.includes((modules.id).toString())){
        $('#module').prop('disabled', false).append('<option value="'+modules.id+'" selected>'+modules.skillset+'</option>');
        }else{
          $('#module').prop('disabled', false).append('<option value="'+modules.id+'" >'+modules.skillset+'</option>');   
        }
        });
        }
        }); 
    });
       
    </script>
@endsection