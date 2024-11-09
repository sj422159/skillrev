@extends('admin/layout')
@section('title','Add Faculty')
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
            <form action="{{url('admin/faculty/savefaculty')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                <label for="GenderId" class="form-control-label">Group Manager Name</label>
                <select class="multisteps-form__select form-control" name="supid"required="true" id="main">
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
                    <label for="jobrole">Staff Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Staff Email Address</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>

                   <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Staff Mobile Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>
                </div>

                <div class="form-row mt-4">
                <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Subject</label>
                    <select id="sub" type="text" class="form-control" name="subject[]"  multiple required="true" multiselect-search="true" multiselect-select-all="true" onchange="mod(this)">
                    </select>
                </div>

                <div class="col-12 col-sm-4 mt-4 mt-sm-0" >
                    <label for="mod">Modules</label>
                    <select id="module" type="text" class="form-control" name="module[]" multiple required="true" multiselect-search="true" multiselect-select-all="true" >
                       
                    </select>
                </div>

                <div class="col-6 col-sm-4 mt-4 mt-sm-0" id="type">
                <label for="domain">Class Teacher</label>
                <select id="at" name="classteacher" type="text" class="form-control" aria-required="true" aria-invalid="false" onchange="edu(this)" required="true">
                <option value="">Select</option>
                @if($classteacher==1)
                <option selected value="1">Yes</option>
                <option value="2">No</option>
                @elseif($classteacher==2)
                <option value="1">Yes</option>
                <option selected value="2">No</option>
                @endif
                </select>
                </div>
            </div>
            <div class="form-row mt-4">
                
                <div class="col-6 col-sm-3 mt-4 mt-sm-0" id="class" style="display:none">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="class" id="mainbranch">
                <option value="">Select</option>
                @foreach($class as $list)
                @if($classid==$list->id){
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                }@else{
                <option  value="{{$list->id}}">{{$list->categories}}</option>
                }
                @endif
                @endforeach
                </select>
                </div>
                <div class="col-6 col-sm-3 mt-4 mt-sm-0" id="section" style="display:none">
                <label for="GenderId" class="form-control-label">Section</label>
                <select id="subbranch" name="section" type="text" class="form-control" aria-required="true" aria-invalid="false" data-val="{{$sectionid}}">
                <option value="">Select</option>
                </select>        
                </div>

                <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        var state = $('#at').val();
        if(state==1){
        document.getElementById('class').style.display="block";
        document.getElementById('section').style.display="block";
        }else{
        document.getElementById('class').style.display="none";
        document.getElementById('section').style.display="none"; 
        }
});
</script>
<script type="text/javascript">
    function edu(that){
        if(that.value==1){
        document.getElementById('class').style.display="block";
        document.getElementById('section').style.display="block";
        }else{
        document.getElementById('class').style.display="none";
        document.getElementById('section').style.display="none"; 
        }
    }

    $(document).ready(function(){
        var values = $('#main').val();
        var sub= <?php echo json_encode($subjectid); ?>;
        sub=Object.values(sub);
        $.ajax({
        url:'{{url("admin/faculty/getsubject/from/supervisor/faculty/{id}")}}',
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

    $(document).ready(function(){
        var values = <?php echo json_encode($subjectid); ?>;
        var sel= <?php echo json_encode($module); ?>;
        //alert (sel);
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



$(document).ready(function(){
$('#main').change(function(){
var state = $('#main').val();
$('#subbranch').html('');
$.ajax({
url:'{{url("admin/faculty/getsubject/from/supervisor/faculty/{id}")}}',
type:'GET',
data:{myID:state},
dataType: "json",
success:function(data){   
$.each(data, function(key,subject){     
$('#sub').prop('disabled', false).append('<option value="'+subject.id+'">'+subject.domain+'</option>');
});
}
});
});
});
    
$(document).ready(function(){
        $('#main').change(function(){
        $('#at').html('');
        var values = $('#main').val();
        $.ajax({
        url:'{{url("admin/faculty/supervisor/group/optionalornot/{id}")}}',
        type:'GET',
        data:{myID:values},
        dataType: "json",
        success:function(data){
        $('#at').prop('disabled', false).append('<option value="">Select</option>'); 
        if(data==2){
        $('#at').prop('disabled', false).append('<option value="'+2+'"selected>No</option>');
        }else{
        $('#at').prop('disabled', false).append('<option value="'+2+'">No</option>');
        $('#at').prop('disabled', false).append('<option value="'+1+'">Yes</option>');
        }  
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

    
</script>
<script type="text/javascript">
$(document).ready(function(){
    var state = $('#mainbranch').val();
    var attr=$('#subbranch').attr('data-val');
    $('#subbranch').html('');
    $.ajax({
        url:'{{url("admin/class/{id}")}}',
        type:'GET',
        data:{myID:state},
        dataType: "json",
        success:function(data){
        $.each(data, function(key,subranches){   
        if(attr==subranches.id){
        $('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+' " selected>'+subranches.section+'</option>');
        }else{
        $('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+'">'+subranches.section+'</option>');
        }
        });
        }
        });
    });

$(document).ready(function(){
$('#mainbranch').change(function(){
var state = $('#mainbranch').val();
$('#subbranch').html('');
$.ajax({
url:'{{url("admin/class/{id}")}}',
type:'GET',
data:{myID:state},
dataType: "json",
success:function(data){
$('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="">Select</option>');   
$.each(data, function(key,subranches){     
$('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+'">'+subranches.section+'</option>');
});
}
});
});
});
</script>
@endsection