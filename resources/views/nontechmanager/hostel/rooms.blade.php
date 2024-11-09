@extends('nontechmanager/hostel/layout')
@section('title','Hostel Rooms')
@section('Dashboard_select','active')
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

<a href="{{url('nontech/manager/hostel/rooms/addrooms')}}"><button type="button"class="btn btn-primary">Create</button></a>
@if(count($room)>0)
<a href="{{url('nontech/manager/hostel/rooms/export')}}/{{$mid}}"><button type="button"class="btn btn-success">Export</button></a>
@endif
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
                        <th>Status</th>
                        <th>Action</th>
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
                        <td>
                            @if($list->status==0)
                             <span class="right badge badge-secondary">No Change</span>
                            @elseif($list->status==1)
                             <span class="right badge badge-warning">Waiting For Approal</span>
                            @elseif($list->status==2)
                             <span class="right badge badge-danger">Rejected</span>
                            @else
                             <span class="right badge badge-success">Agreed</span>
                            @endif
                        </td>
                        <td>
                             @if($list->status==0)
                            <a href="{{url('nontech/manager/hostel/rooms/addrooms')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                            @elseif($list->status==1)
                             <a href="" disabled ><button type="button" class="btn btn-sm btn-secondary">Wait</button></a>
                            @else
                              <a href="{{url('nontech/manager/hostel/rooms/confirm/change')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-primary">Confirm</button></a>
                            @endif
                            </a>
                        </td>
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