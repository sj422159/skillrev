@extends('admin/layout')
@section('title','Student List')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12" style="margin:10px;background-color: #fff;padding:5px;margin-top:0px;padding-top: 10px;">
  
<form action="{{url('admin/studentdetails/bysection')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control" name="class" id="clas" data-val="{{$section}}" required onchange="sec(this)">
                <option value="">Select</option>
                @foreach($classes as $list)
                @if($class==$list->id)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @else
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>SECTION</label>
            <select class="form-control" required  name="section" id="section"> 
            </select>
        </div>
         
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch</button>
          </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>Download</label>
            @if(count($details)>0)
                <a href="{{url('admin/studentdetails/export')}}/{{$class}}/{{$section}}"><button type="button" class="btn btn-primary">Export</button>
                </a>
            @else
                <button type="button" class="btn btn-primary disabled">Export</button>
            @endif
        </div>
        </div>
</form>          
</div>
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $list)
                    <tr>
                        <td>{{$list->sname}}</td>
                        <td>{{$list->semail}}</td>
                        <td>{{$list->snumber}}</td>
                        <td>
                            <a href="{{url('admin/studentdetails/view')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-success">view</button>
                            </a>
                        </td>
                        <td>
                            @if($list->status==1)
                                  <a href="{{url('admin/student/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-primary">Active</button>
                                  </a> 
                               @elseif($list->status==0)
                                 <a href="{{url('admin/student/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-warning">Deactive</button>
                                  </a>
                               @endif
                        </td>
                        <td> 
                            <a href="{{url('admin/student/delete')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script type="text/javascript">

  function sec(that){
          var classid = that.value;
          var sectionid=$('#clas').attr('data-val');
                        
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
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


$(document).ready(function(){
    var classid = $('#clas').val();
          var sectionid=$('#clas').attr('data-val');           
           $('#section').html('');
            $.ajax({
              url:'{{url("admin/classby/section/{id}")}}',
              type:'GET',
              data:{id:classid},
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
});   
          

           
</script>
@endsection