@extends('nontechmanager/infrastructure/layout')
@section('title','Repairs')
@section('Dashboard_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

 <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:10px">

    <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Hostel Additional Infrastructure</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Hostel</a></li>
                <!--   <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">School</a></li>
                   <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Cafeteria</a></li> -->
                </ul>
    </div> 
     <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Hostel</th>
                        <th>Room No</th>
                        <th>Intial Capacity</th>
                        <th>Updated Capacity</th>
                        <th>Difference</th>
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $list)
                    <tr>
                    <td>{{$list->hostel}}</td>
                  <td>{{$list->roomname}}</td>
                  <td>{{$list->initialcapacity}}</td>
                  <td>{{$list->Bedcapacity}}</td>
                  @php
                  $val=(int)$list->Bedcapacity-(int)$list->initialcapacity;
                  @endphp
                  <td>@if($val>0)
                    <span class="right badge badge-success">+ {{$val}}  &nbsp &nbsp Increase</span>
                     @else
                     <span class="right badge badge-danger">{{$val}}  &nbsp &nbspDecrease</span>
                     @endif

                    </td>
                  

                  <td>
                    @if($list->status==1)
                    <a href="{{url('nontech/manager/infrastructure/room/change/approval')}}/{{$list->id}}/3" class="btn btn-primary btn-sm">Agree</a>
                     <a href="{{url('nontech/manager/infrastructure/room/change/approval')}}/{{$list->id}}/2" class="btn btn-primary btn-sm">Reject</a>
                    @elseif($list->status==2)
                       <a href=""  class="disabled btn btn-danger btn-sm">Rejected</a>
                    @else
                         <a href=""  class="disabled btn btn-success btn-sm">Agreed</a>
                    @endif
                </td>
              </tr>
                    @endforeach
                  
               

                     
                   
                </tbody>
            </table>
        </div>
    </div>
                      <div class="tab-pane" id="tab_2">
             <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Item</th>
                        <th>Model Code</th>
                        <th>Item No</th>
                        <th>Item Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
             
                     
                   
                </tbody>
            </table>
        </div>
    </div>
      <div class="tab-pane" id="tab_2">
             <div class="table-responsive table" style="padding:20px">
        <table id="example2" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Item</th>
                        <th>Model Code</th>
                        <th>Item No</th>
                        <th>Item Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
             
                     
                   
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
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
    $('#example2').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>
@endsection