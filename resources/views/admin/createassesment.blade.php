@extends('admin/layout')
@section('title','Create Assesment')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{url('admin/assesment/createmodule')}}" method="post" enctype="multipart/form-data">
                @csrf
            
            <div class="card-body">
                  
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="">Assesment Type</label>
                        <select id="" name="atype" type="text" class="form-control" required="true">
                            <option value="">Select</option>
                        @foreach($asstype as $list)
                            @if($atype==$list->asstype)
                            <option selected value="{{$list->asstype}}">{{$list->asstype}}</option>
                            @else
                            <option value="{{$list->asstype}}">{{$list->asstype}}</option>
                            @endif
                            @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="training">Manager</label>
                        <select id="manager" type="text" class="form-control" name="mid" required="true">
                            <option value="">Select</option>
                            @foreach($managers as $list)
                            @if($mid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->mname}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->mname}}</option>
                            @endif
                            @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="training">Training Type</label>
                        <select id="training" type="text" class="form-control" name="ttype" required="true">
                            <option value="">Select</option>
                             @foreach($trainings as $list)
                            @if($ttype==$list->id)
                            <option selected value="{{$list->id}}">{{$list->type}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->type}}</option>
                            @endif
                            @endforeach
                       </select>
                    </div>
                     <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="trains">Training Program</label>
                        <select id="trains" name="training" type="text" data-val="{{$training}}" class="form-control" required="true">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="branchname">Assesment Time</label>
                        <input type="number" min="1" max="180" class="form-control" id="childbranch" placeholder="In Minutes" name="assesmenttotaltime" value="{{$assesmenttotaltime}}" required="true">
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="image" class="control-label mb-1">Assesment Image</label>
                        @if($id>0)
                        <input id="image" name="assesmentimage" type="file" class="form-control">
                        <img src="{{asset('assesmentimages')}}/{{$assesmentimage}}" width="130px" height="80px" alt="Assesment Image">
                        @else
                        <input id="image" name="assesmentimage" type="file" class="form-control" required="true">
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="sector">Short Description</label>
                        <textarea class="form-control" rows="3" name="sdesc" maxlength="50" placeholder="Please Provide Short Description Upto 50 characters" required="true">{{$sdesc}}</textarea>
                    </div>
                </div>
                   
                <input type="hidden" name="id" value="{{$id}}">
                <div class="form-row mt-4">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

   <script type="text/javascript">

        $(document).ready(function(){
                   var state = $('#training').val();
                   var manager = $('#manager').val();
                   var subbranch=$('#trains').attr('data-val');
           $('#trains').html('');
            $.ajax({
              url:'{{url("admin/trainings/trains/{id}")}}',
              type:'GET',
              data:{id:state,mid:manager},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,trainings)
                 {   
                   if(subbranch==trainings.id){
                       $('#trains').prop('disabled', false).append('<option value="'+trainings.id+' " selected>'+trainings.trainingname+'</option>');
                   }else{
                        $('#trains').prop('disabled', false).append('<option value="'+trainings.id+'">'+trainings.trainingname+'</option>');
                   }
                });
              
              }
          });
          });


         $(document).ready(function(){
        $('#training').change(function(){
          
           var state = $('#training').val();
           var manager = $('#manager').val();
           $('#trains').html('');
            $.ajax({
             url:'{{url("admin/trainings/trains/{id}")}}',
              type:'GET',
              data:{id:state,mid:manager},
              dataType: "json",
              success:function(data)
              { 
                $('#trains').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,trainings){    
                  $('#trains').prop('disabled', false).append('<option value="'+trainings.id+'">'+trainings.trainingname+'</option>');
                });
              }
          });
        });
      });
    </script>


@endsection
