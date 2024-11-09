@extends('admin/layout')
@section('title','Add cafeteria')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/cafeteria/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                     <div class="form-group">
                        <label for="ctype">Categories Type</label>
                        <select class="form-control" name="cattype" required onchange="dis(this)"> 
                            <option value="">Select</option>
                                @foreach($ctypes as $list)
                                  @if($list->id==$ctype))
                                   <option value="{{$list->id}}" selected>{{$list->ctype}}</option>
                                  @else
                                   <option value="{{$list->id}}">{{$list->ctype}}</option>
                                  @endif
                                @endforeach
                          
                             
                        </select>
                    </div>
                     <div class="form-group" id="hos" style="display:none">
                        <label for="ctype">Hostel</label>
                        <select class="form-control" name="hostel" id="host"> 
                            <option value="">Select</option>
                                @foreach($hostel as $list)
                                  @if($list->id==$hostelid)
                                   <option value="{{$list->id}}" selected>{{$list->hostel}}</option>
                                  @else
                                   <option value="{{$list->id}}">{{$list->hostel}}</option>
                                  @endif
                                @endforeach
                          
                             
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jobcafeteria">Cafeteria</label>
                        <input type="text" class="form-control" id="jobcafeteria" required="true" placeholder="Enter cafeteria Name" name="cafeteria" value="{{$cafeteria}}">
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
<script type="text/javascript">
   var hos=<?php echo $hostelid ; ?>;
  
   if(hos==0){
       document.getElementById("host").value=0;
   }else{
     document.getElementById("hos").style.display="block";
   }



    function dis(that){
        //alert(that.value);
        if(that.value==2){
          document.getElementById("hos").style.display="block";
           document.getElementById("host").value="";
        }else{
          document.getElementById("hos").style.display="none";
           document.getElementById("host").value=0;
        }
    }
</script>
@endsection