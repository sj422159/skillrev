@extends('nontechgroupmanager/layout')
@section('title','Room Details')
@section('Profile','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 
        
@if(session()->has('danger'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('danger')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
@endif

 <div class="row col-12">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
        <form action="{{url('nontech/groupmanager/room/info/byfilter')}}" method="post">
            @csrf
        <div class="form-group">
            <select class="form-control" name="hostel" required>
                <option value="">Select Hostel</option>
                @foreach($hostels as $list)
                @if($list->id==$hostelid)
                <option value="{{$list->id}}" selected>{{$list->hostel}}</option>
                @else
                 <option value="{{$list->id}}">{{$list->hostel}}</option>
                @endif
                @endforeach
            </select>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
    </div>
    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
        <button type="submit" class="btn btn-success">Get Details</button>
    </div>
    @if(count($room)>0)
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <a href="{{url('nontech/groupmanager/room/info/byfilter/export')}}/{{$id}}">
                <button type="button" class="btn btn-primary" style="margin-bottom:10px !important;">
                    Export
                </button> 
            </a>
        </div>
    @endif
    </form>
</div>
    </div>

<div class="row">
    <div class="col-md-12">
           <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Room</th>
                        <th>Hostel Name</th>
                        <th>Bed Capacity</th>
                        <th>Allocated Beds</th>
                        <th>Assigned Beds</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($room as $list)
                    <tr>
                        <td>{{$list->roomname}}</td>
                        <td>{{$list->hostel}}</td>
                        <td>{{$list->Bedcapacity}}</td>
                        <td>{{$list->allocated}}</td>
                        <td>{{$list->assigned}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript"> 
  $(document).ready(function() {
   $('#example1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
   
} );
</script>
@endsection