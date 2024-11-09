@extends('marketingofficer/layout')
@section('page_title','Call List')
@section('dashboard','active extra')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="row">
          <div class="col-12">
            <div class="card">
<div class="card-header">
<a href="{{url('employee/marketingofficer/createcoldcall')}}" style="margin-bottom:20px;">
<button type="button" class="btn btn-primary btn-sm">Add List</button></a>
</div>

       <div class="table-responsive table" style="padding:20px">
                          
                                      <table id="example1" class="display nowrap" style="width:100%   ">
      <thead>
         <br>
         <tr>
            
                  
                  <th>Type</th>
                  <th>Name</th>
                  <th>Location</th>
                  <th>Address</th>
                  <th>POC</th>
                  <th>Designation</th>
                  <th>Email</th>
                  <th>Number</th>
                  <th>Status</th>  
                  <th>Action</th>
         </tr>
    </thead>
    <tbody>
        
        @foreach($data as $list)
            <tr>   
                <td>{{$list->type}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->location}}</td>
                <td>{{$list->address}}</td>
                <td>{{$list->poc}}</td>
                <td>{{$list->designation}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->number}}</td>
                <td>
                    @if($list->status==0)
                    <span class="right badge badge-primary">Created</span>
                    @elseif($list->status==1)
                    <span class="right badge badge-danger">Rejected</span>
                    @elseif($list->status==2)
                    <span class="right badge badge-info">Asked Help</span>
                    @endif
                </td>
                <td>
                    @if($list->status==0)
                    <a href="{{url('employee/marketingofficer/coldcall/need/help')}}/{{$list->id}}"><span class="right badge badge-primary">Need Help</span></a>
                    <a href="{{url('employee/marketingofficer/coldcall/reject')}}/{{$list->id}}"><span class="right badge badge-danger">Reject</span></a>
                    @elseif($list->status==1)
                    <span class="right badge badge-secondary">Not Applicable</span>
                    @elseif($list->status==2)
                    <span class="right badge badge-secondary">Not Applicable</span>
                    @endif
                    
                </td>   
            </tr>
        @endforeach
    </tbody>
    </table>
              </div>

</div>
</div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
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