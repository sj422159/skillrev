@extends('manager/layout')
@section('title','Add Training')
@section('Dashboard_select','active')
@section('container')
<div class="row">
<div class="col-10" style="margin:20px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Training Program</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('manager/trainingprogram/savetraining')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                <div class="form-row">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Faculty</label>
                        <select name="facultyid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($faculties as $list)
                            @if($facultyid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->fname}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->fname}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                        <label for="jobskill">Training Type</label>
                        <select id="type" name="trainingtype" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($trainingtypes as $list)
                            @if($trainingtype==$list->id)
                            <option selected value="{{$list->id}}">{{$list->type}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->type}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <label for="jobrole">Training Name </label>
                      <input type="text" class="form-control" id="jobrole" placeholder="Enter Training Name" name="trainingname" value="{{$trainingname}}" required="true">
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="jobskill">Standard</label>
                        <select id="mainbranch" name="category" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($categories as $list)
                            @if($category==$list->id)
                            <option selected value="{{$list->id}}">{{$list->categories}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                            <label for="branchname">Subject</label>
                            <select name="domain" class="form-control" required="true" data-val="{{$domain}}" id="subbranch">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="singlemodule">
                            <label for="branchname">Module</label>
                            <select name="skillset" class="form-control" required="true" data-val="{{$skillset}}" id="subskillset">
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="arraymodule">
                            <label for="branchname">Module</label>
                            <select name="skillset[]" class="form-control" required="true" id="subskillset1" multiple multiselect-search="true" multiselect-select-all="true" >
                            @if($id>0)
                            @foreach($skillsets as $list)
                            <option selected value="{{$list->id}}">{{$list->skillset}}</option>
                            @endforeach
                            @endif
                            </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="chapter">
                            <label for="branchname">Chapter</label>
                            <select name="skillattribute" class="form-control" required="true" data-val="{{$skillattribute}}" id="skillattribute">
                            </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                        <label for="sector">Description</label>
                        <textarea class="form-control" rows="6" name="description" maxlength="450" placeholder="Please Provide Description Upto 250 characters" required="true">{{$description}}</textarea>
                    </div>
                </div>
                 
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                      <label for="image" class="control-label mb-1">Image</label>
                       @if($id>0)
                        <input id="image" name="image" type="file" class="form-control">
                        <img src="{{asset('trainingimages')}}/{{$image}}" width="130px" height="80px" alt="Training Image">
                       @else
                        <input id="image" name="image" type="file" class="form-control" required="true">
                       @endif 
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
        var type = $('#type').val(); 
        if(type=="1"){
            document.getElementById("chapter").style.display="block";
            document.getElementById("arraymodule").style.display="none";
            document.getElementById("subskillset1").required=false;
            document.getElementById("singlemodule").style.display="block";
        }
        else{
            document.getElementById("chapter").style.display="none";
            document.getElementById("skillattribute").required = false;
            document.getElementById("singlemodule").style.display="none";
            document.getElementById("subskillset").required=false;
            document.getElementById("arraymodule").style.display="block";
        }        
    });
    $(document).ready(function(){
        $('#type').change(function(){
            var type = $('#type').val(); 
            if(type=="1"){
                document.getElementById("chapter").style.display="block";
                document.getElementById("arraymodule").style.display="none";
                document.getElementById("subskillset1").required=false;
                document.getElementById("singlemodule").style.display="block";
            }
            else{
                document.getElementById("chapter").style.display="none";
                document.getElementById("skillattribute").required = false;
                document.getElementById("singlemodule").style.display="none";
                document.getElementById("subskillset").required=false;
                document.getElementById("arraymodule").style.display="block";
            } 
        });
    });
</script>
<script type="text/javascript">
    
        $(document).ready(function(){
            var state = $('#mainbranch').val();
            var subbranch=$('#subbranch').attr('data-val');

           $('#subbranch').html('');
            $.ajax({
              url:'{{url("manager/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.domain+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                   }
                });
               subskillset();
               skillattribute();
              }
          });
          });

         function subskillset(){
                   var state = $('#subbranch').val();
                   var subskillset=$('#subskillset').attr('data-val');
                  
           $('#subskillset').html('');
            $.ajax({
              url:'{{url("manager/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillset+'</option>');
                   }else{
                        $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                   }
                });
              }
          });
          };

        function skillattribute(){
            var state = $('#subskillset').attr('data-val');
            var subskillset=$('#skillattribute').attr('data-val');    
           $('#skillattribute').html('');
            $.ajax({
              url:'{{url("manager/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.skillattribute+'</option>');
                   }else{
                        $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                   }
                });
              }
          });
          };
       $(document).ready(function(){
        $('#mainbranch').change(function(){

           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("manager/skillattribute/domain/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                 $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                });
              }
          }); 
        });
      });
    $(document).ready(function(){
        $('#subbranch').change(function(){
           var state = $('#subbranch').val();
           $('#subskillset').html('');
           $('#subskillset1').html('');
            $.ajax({
             url:'{{url("manager/skillattribute/skillset/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#subskillset').prop('disabled', false).append('<option value="">Select</option>'); 
                $('#subskillset1').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#subskillset').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                  $('#subskillset1').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillset+'</option>');
                });
              }
          });
        });
    });

    $(document).ready(function(){
        $('#subskillset').change(function(){
           var state = $('#subskillset').val();
           $('#skillattribute').html('');
            $.ajax({
             url:'{{url("manager/skillattribute/getskillattribute/{id}")}}',
              type:'GET',
              data:{id:state},
              dataType: "json",
              success:function(data)
              { 
                $('#skillattribute').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#skillattribute').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.skillattribute+'</option>');
                });
              }
          });
        });
      });
    </script>

@endsection
