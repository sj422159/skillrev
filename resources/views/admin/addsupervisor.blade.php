@extends('admin/layout')
@section('title','Add Group Manager')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Group Manager</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/supervisor/savesupervisor')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Group</label>
                <select class="multisteps-form__select form-control" name="groupid" id="mainbranch" required="true" onchange="subject(this)">
                <option value="">Select</option>
                @foreach($groups as $list)
                @if($groupid==$list->id)
                <option selected value="{{$list->id}}">{{$list->group}}</option>
                @else
                <option  value="{{$list->id}}">{{$list->group}}</option>
                
                @endif
                @endforeach
                </select>
                </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Email</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>
              </div>
              <div class="form-row mt-4">
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>

                <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
     function subject(that){
        $('#sub').html('');
        var values = $('#mainbranch').val();
        $.ajax({
        url:'{{url("admin/faculty/getsubject/{id}")}}',
        type:'GET',
        data:{myID:values},
        dataType: "json",
        success:function(data){
        $.each(data, function(key,subject){   
        $('#sub').prop('disabled', false).append('<option value="'+subject.id+'">'+subject.domain+'</option>');
        });
        }
        });
        
    } 
    $(document).ready(function(){
        var values = $('#mainbranch').val();
        var sub= <?php echo json_encode($subjectid); ?>;
        sub=Object.values(sub);
        $.ajax({
        url:'{{url("admin/faculty/getsubject/{id}")}}',
        type:'GET',
        data:{myID:values},
        dataType: "json",
        success:function(data){
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