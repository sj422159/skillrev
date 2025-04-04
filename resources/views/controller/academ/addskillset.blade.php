@extends('controller/academ/layout')
@section('title','Add Module')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <form action="{{url('academic_controller/skillset/saveskillset')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                        <label for="jobskill">Education</label>
                        <select id="mainbranch" name="groupid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($groups as $list)
                            @if($groupid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->group}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->group}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="branchname">Specialisation</label>
                            <select name="category" class="form-control" data-val="{{$category}}" id="subbranch" required="true">
                            </select>
                    </div>
                    <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                            <label for="branchname">Subject</label>
                            <select name="domain"class="form-control" required="true" data-val="{{$domain}}" id="childbranch">
                            </select>
                    </div>
                </div>
                    
                    <div class="form-row mt-2">
                    <div class="col-12 col-sm-12 mt-2 mt-sm-0">
                        <label for="jobrole">Module</label>
                        <input type="text" class="form-control" id="jobrole" placeholder="Enter Module Name" name="skillset" value="{{$skillset}}" required="true">
                    </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
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
            var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("academic_controller/skillset/getcategory/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.categories+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.categories+'</option>');
                   }
                });
               subskillset();
              }
          });
          });

         function subskillset(){
                   var state = $('#subbranch').val();
                   var groupid = $('#mainbranch').val();
                   var subskillset=$('#childbranch').attr('data-val');   
           $('#childbranch').html('');
            $.ajax({
              url:'{{url("academic_controller/skillset/domain/{id}/{groupid}")}}',
              type:'GET',
              data:{id:state,groupid:groupid},
              dataType: "json",
              success:function(data)
              {
                
                 $.each(data, function(key,jobroles)
                 {   
                   if(subskillset==jobroles.id){
                       $('#childbranch').prop('disabled', false).append('<option value="'+jobroles.id+'" selected >'+jobroles.domain+'</option>');
                   }else{
                        $('#childbranch').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.domain+'</option>');
                   }
                });
              }
          });
          };
       $(document).ready(function(){
        $('#mainbranch').change(function(){

           var state = $('#mainbranch').val();
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("academic_controller/skillset/getcategory/{id}")}}',
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
              }
          }); 
        });
      });
        $(document).ready(function(){
        $('#subbranch').change(function(){
          
           var state = $('#subbranch').val();
           var groupid = $('#mainbranch').val();
           $('#childbranch').html('');
            $.ajax({
             url:'{{url("academic_controller/skillset/domain/{id}/{groupid}")}}',
              type:'GET',
              data:{id:state,groupid:groupid},
              dataType: "json",
              success:function(data)
              { 
                $('#childbranch').prop('disabled', false).append('<option value="">Select</option>'); 

                $.each(data, function(key,jobroles)
                 {    

                  $('#childbranch').prop('disabled', false).append('<option value="'+jobroles.id+'">'+jobroles.domain+'</option>');
                });
              }
          });
        });
      });
       
    </script>

@endsection