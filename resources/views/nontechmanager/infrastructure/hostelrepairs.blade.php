@extends('nontechmanager/infrastructure/layout')
@section('title','Hostel Repairs')
@section('Dashboard_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<style type="text/css">
    th{
        font-size: 14px;

    }
    td{
        font-size: 12px;
    }
</style>
 <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:10px">

    <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Hostel Repairs</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Hostel</a></li>
                 <!--  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">School</a></li>
                   <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Cafeteria</a></li> -->
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
                        <th>Item</th>
                        <th>Model Code</th>
                        <th>Item No</th>
                        <th>Item Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $list)
                    <tr>
                    <td>{{$list->hostel}}</td>
                  <td>{{$list->roomname}}</td>
                  <td>{{$list->infraitem}}</td>
                  <td>{{$list->itemcode}}</td>
                  <td>{{$list->itemno}}</td>
                  <td>{{$list->itemdesc}}</td>

                  <td>
                    @if($list->repair==1)
                    <a href="{{url('nontech/manager/infrastructure/repair/start')}}/{{$list->id}}" class="btn btn-primary btn-sm">start</a>
                    @else
                       <a href="#" class="btn disabled btn-warning btn-sm">Pending Confirmation</a>
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
       <!--  <table id="example2" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Faculty</th>
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
            </table> -->
        </div>
    </div>
      <div class="tab-pane" id="tab_3">
             <div class="table-responsive table" style="padding:20px">
       <!--  <table id="example3" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Cafeteria Type</th>
                        <th>Cafeteria</th>
                        <th>Item</th>
                        <th>Model Code</th>
                        <th>Item No</th>
                        <th>Item Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                     
                   
                </tbody>
            </table> -->
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
    $('#example3').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>
@endsection