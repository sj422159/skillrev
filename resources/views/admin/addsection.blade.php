@extends('admin/layout')
@section('title','Add Section')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <form action="{{url('admin/section/savesection')}}"method="post"enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="jobskill">Group</label>
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
                    <div class="form-group">
                           <label for="branchname">Class</label>
                           <select name="classid"class="form-control"required="true" data-val="{{$classid}}" id="subbranch">
                           </select>
                    </div>
                    <div class="form-group">
                        <label for="jobrole">Section Name</label>
                        <input type="text" class="form-control" id="jobrole" placeholder="Enter Section Name" name="section" value="{{$section}}" required="true">
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
            var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/section/getclass/{id}")}}',
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
              
              }
          });
          });

         
        $(document).ready(function(){
        $('#mainbranch').change(function(){
           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/section/getclass/{id}")}}',
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
       
    </script>
@endsection