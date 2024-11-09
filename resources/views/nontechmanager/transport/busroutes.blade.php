@extends('nontechmanager/transport/layout')
@section('title','Bus Routes')
@section('Dashboard_select','active')
@section('container')
<style type="text/css">
    td,
    a,
    button {
        font-size: 12px;
        word-wrap: break-word !important;
    }

    th {
        font-size: 14px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"> 
@if(session()->has('success')) <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    <span class="badge badge-pill badge-success"></span>
    {{session('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div> @endif
    <div class="row">
        <div class="col-12">
    <form action="{{url('nontech/manager/transportstudents/by/busroute')}}" id="a" method="post">
    @csrf
    </form>
    <div class="form-row">
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Bus Routes</label>
            <select class="form-control" name="busroute" form="a" required id="mainbranch" data-val="{{$location}}" required onchange="loc(this)">
                <option value="">Select</option>
                @foreach($busroutes as $list) 
                @if($busroute==$list->id)
                <option selected value="{{$list->id}}">{{$list->busroute}}</option>
                @else
                <option value="{{$list->id}}">{{$list->busroute}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Locations</label>
            <select class="form-control" name="location" form="a" required id="subbranch" onchange="yes(this)">
                <option value="">Select</option>
            </select>
        </div>
        <form action="{{url('nontech/manager/transportstudents/savetime')}}" id="b" method="post">
        @csrf
        </form>
        <input type="hidden" value="{{$location}}" class="form-control" required="true" name="locationid" form="b">  
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Pickup-Time</label>
            @if(count($loc)>0)
            <input type="time" class="form-control" required="true" name="pickuptime" form="b" value="{{$loc[0]->pickuptime}}">
            @else
            <input type="time" class="form-control" required="true" name="pickuptime" form="b">
            @endif   
        </div>
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Drop Time</label>
            @if(count($loc)>0)
            <input type="time" class="form-control" required="true" name="droptime" form="b" value="{{$loc[0]->droptime}}">
            @else
            <input type="time" class="form-control" required="true" name="droptime" form="b">
            @endif   
        </div>
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>Action</label> 
            <button type="submit" class="btn btn-success form-control" form="b">Save</button>   
        </div>
        <div class="col-12 col-sm-2 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <button type="submit" class="btn btn-success form-control" form="a" id="getjobroles" hidden="true">Fetch</button>
        </div>
    </div>
<div class="card mt-4">
    <!-- /.card-header -->
    <div class="table-responsive table" style="padding:20px" style="width:100%">
        <table id="example1" class="display wrap" style="width:100%">
            @if(count($students)>0)
            <a href="{{url('nontech/manager/transportstudents/export')}}/{{$location}}" class="btn btn-primary btn-sm">Export</a>
            @else
            <a href="#" class="btn btn-primary disabled btn-sm">Export</a>
            @endif
            <thead>
                <tr>
                    <th>Id</th>
                    <!-- <th>Profile</th> -->
                    <th>Student Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Bus Route</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
              @php
              $count=1;
              @endphp
              @foreach($students as $list)
               <tr>
                <td>{{$count}}</td>
                <!-- <td><img src="{{asset('studentimages')}}/{{$list->image}}"width="80px"height="80px"alt="User Image"></td> -->
                <td>{{$list->sname}} {{$list->slname}}</td>
                <td>{{$list->snumber}}</td>
                <td>{{$list->semail}}</td>
                <td>{{$list->busroute}}</td>
                <td>{{$list->location}}</td>
               </tr>
               @php
              $count++;
              @endphp
              @endforeach  
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
<script>
  function yes(that) {
    if(that.value != " ") { 
        document.getElementById('getjobroles').click();   
    } 
  }
</script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script>
    function loc(that){
        var busrouteid = that.value;
        var locationid=$('#mainbranch').attr('data-val');              
            $('#subbranch').html('');
            $.ajax({
              url:'{{url("nontech/manager/view/locations/{id}")}}',
              type:'GET',
              data:{id:busrouteid},
              dataType: "json",
              success:function(data){
                $('#subbranch').prop('disabled', false).append('<option value="">Select</option>');
                $.each(data, function(key,location){   
                    if(locationid==location.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+location.id+'" selected>'+location.location+'</option>');
                    }else{
                       $('#subbranch').prop('disabled', false).append('<option value="'+location.id+'">'+location.location+'</option>');
                   }
                });
            }
        });
    }

        var busrouteid = $('#mainbranch').val();
        var locationid=$('#mainbranch').attr('data-val');             
            $('#subbranch').html('');
            $.ajax({
              url:'{{url("nontech/manager/view/locations/{id}")}}',
              type:'GET',
              data:{id:busrouteid},
              dataType: "json",
              success:function(data)
              {
                 $('#subbranch').prop('disabled', false).append('<option value="">Select</option>');
                 $.each(data, function(key,location)
                 {   
                   if(locationid==location.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+location.id+'" selected >'+location.location+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+location.id+'">'+location.location+'</option>');
                   }
                });
              }
          });

</script> 

@endsection                 