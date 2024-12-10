@extends('admin/layout')
@section('title','Add Category')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Fees Discount</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/fees/savediscount')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row mt-4">
                  
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Category</label>
                        <select class="form-control" name="discat" id="category" onchange="check(this)">
                            <option value="">Select</option>
                            @foreach($categories as $list)
                            @if($discat==$list->id)
                            <option value="{{$list->id}}**{{$list->fctype}}"selected>{{$list->fcategory}}</option>
                            @else
                            <option value="{{$list->id}}**{{$list->fctype}}">{{$list->fcategory}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Fees Type</label>
                        <select class="form-control" id="ftype" name="type"  data-name="cls" >
                            <option value="">Select</option>
                            @foreach($types as $list)
                            @if($distype==$list['type'])
                            <option selected value="{{$list['type']}}**{{$list['id']}}">{{$list['id']}}</option>
                            @else
                            <option value="{{$list['type']}}**{{$list['id']}}">{{$list['id']}}</option>
                            @endif
                            @endforeach
                        </select>
                        
                    </div>

                     <div class="col-12 col-sm-4">
                        <label for="jobrole">Class</label>
                        <select class="form-control" name="category" data-val="{{$discls}}" id="cls" onchange="sec(this)">
                        <option value="">Select</option>
                        @foreach($class as $list)
                           @if($discls==$list->id)
                            <option selected value="{{$list->id}}**{{$list->categories}}">{{$list->categories}}</option>
                           @else
                            <option value="{{$list->id}}**{{$list->categories}}">{{$list->categories}}</option>
                            @endif
                        @endforeach
                       </select>
                    </div>
                     
                    
                </div>
                 <div class="form-row mt-4">
                   

                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Section</label>
                        <select class="form-control" id="section" data-val="{{$dissec}}" name="section" onchange="stu(this)">
                            <option value="">Select</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-4" id="dist" style="display:none">  
                        <label for="jobrole">Distance</label>
                        <select class="form-control" name="type2"  id="dis"  data-name="dis" >
                           <option value="">Select</option>
                           @foreach($distances as $list)
                            @if($distance==$list->id)
                            <option selected value="{{$list->id}}**{{$list->distance}} Km">{{$list->distance}} Km</option>
                            @else
                            <option value="{{$list->id}}**{{$list->distance}} Km">{{$list->distance}} Km</option>
                            @endif
                           @endforeach
                        </select>
                    </div>

                    
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Students</label>
                        <select class="form-control" id="students" data-val="{{$studentid}}" required name="students" onchange="fee(this)">
                            <option value="">Select</option>       
                        </select>
                    </div>
                   
                </div>
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Fees</label>
                       <input type="number" name="fees" id="fe" placeholder="Enter Fees" class="form-control" value="{{$fees}}" readonly>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Discount</label>
                        <select class="form-control" name="dis" onchange="discount(this)" required> 
                            <option value="">Select</option>
                            @foreach($per as $list)
                            @if($dis==$list)
                            <option selected value="{{$list}}">{{$list}}%</option>
                            @else
                            <option value="{{$list}}">{{$list}}%</option>
                            @endif
                            @endforeach     
                        </select>
                    </div> 
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Total Fees</label>
                       <input type="number" name="tfees" placeholder="Enter Fees" class="form-control" value="{{$disprice}}" readonly id="tfees">
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">

    function check(that){
        var val=that.value.split("**");
        if(val[1]==1){
            document.getElementById('dist').style="display:none";  
        }else{
          document.getElementById('dist').style="display:block";  
        }
    }

    function fee(that) {
        var cat = $('#category').val().split("**");
        var type=$('#ftype').val();
        var cls=$('#cls').val().split("**");
        var dis="";
        if(cat[1]){
          dis=$('#dis').val();
        }
            $.ajax({
              url:'{{url("admin/fees/discount/getfees/")}}',
              type:'GET',
              data:{cat:cat[0],type:type,cls:cls[0],dis:dis},
              dataType: "json",
              success:function(data)
              {
                document.getElementById('fe').value=data;
              }
          });  
    }
    

    function sec(that){
        var classid =  that.value.split("**");
        var sectionid=$('#class').attr('data-val');               
            $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid[0]},
              dataType: "json",
              success:function(data)
              {
                 $('#section').prop('disabled', false).append('<option value="">Select</option>');
                
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

    function stu(that){
        var classid =$('#cls').val();
        classid=classid.split("**");
        var sectionid=$('#section').val();               
           $('#students').html('');
            $.ajax({
              url:'{{url("admin/fees/getstudents/")}}',
              type:'GET',
              data:{id:classid[0],sec:sectionid},
              dataType: "json",
              success:function(data)
              {
                 $('#students').prop('disabled', false).append('<option value="">Select</option>');
                
                 $.each(data, function(key,student)
                 {   
                    $('#students').prop('disabled', false).append('<option value="'+student.id+'">'+student.sname+'</option>');
                });
              }
        });
    }

function discount(that){
    var fee= document.getElementById('fe').value;
    var dis=that.value;
    tfees=parseInt(fee)-(parseInt(fee)*parseInt(dis)/100);
    document.getElementById('tfees').value=tfees;
}


$(document).ready(function(){
        var classid =  $('#cls').val().split("**");
        var sectionid=$('#section').attr('data-val');              
            $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid[0]},
              dataType: "json",
              success:function(data)
              {
                $('#section').prop('disabled', false).append('<option value="">Select</option>');
                
                $.each(data, function(key,section){   
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
        var classid =$('#cls').val().split("**");
        var sectionid=$('#section').attr('data-val');   
        var studentid=$('#students').attr('data-val');              
           $('#students').html('');
            $.ajax({
              url:'{{url("admin/fees/getstudents/")}}',
              type:'GET',
              data:{id:classid[0],sec:sectionid},
              dataType: "json",
              success:function(data)
              {
                $('#students').prop('disabled', false).append('<option value="">Select</option>');
                
                $.each(data, function(key,student){ 
                if(studentid==student.id){  
                    $('#students').prop('disabled', false).append('<option selected value="'+student.id+'">'+student.sname+'</option>');
                }else{
                    $('#students').prop('disabled', false).append('<option value="'+student.id+'">'+student.sname+'</option>');
                }
                });
              }
        });    
});


$(document).ready(function(){
        var val=$('#category').val().split("**");
        if(val[1]==1){
            document.getElementById('dist').style="display:none";  
        }else{
          document.getElementById('dist').style="display:block";  
        }
});

</script>
@endsection