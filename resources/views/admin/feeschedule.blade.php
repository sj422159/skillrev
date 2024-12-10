@extends('admin/layout')
@section('title','Regular Fees Schedule')
@section('manager_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<a href="{{url('admin/fees/addschedule')}}">
<button type="button" class="btn btn-primary">Regular Fees Schedule</button>  </a>
 <div class="row" >
          <div class="col-12">
            <!-- Custom Tabs -->
           
            <div class="card" style="margin-top:10px">

    <!-- <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Regular Fees Schedule</h3>
                 
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Regular</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Transport</a></li>
                </ul>
    </div> -->
     <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Category</th>
                        <th>Class</th>
                        <th>Annual</th>
                        <th>Half Yearly</th>
                        <th>Quarterly</th>
                        <th>Monthly</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                @foreach($otherdata as $list)
                    <tr>
                        <td>{{$list->fcategory}}</td>
                        <td>{{$list->shtypename}}</td>
                        <td>{{$list->shannual}}</td>
                        <td>{{$list->shhalf}}</td>
                        <td>{{$list->shquater}}</td>
                        <td>{{$list->shmonthly}}</td>

                        <td>
                            <a href="{{url('admin/fees/addschedule')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/fees/schedule/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
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
                        <th>Category</th>
                        <th>Type</th>
                        <th>Annual</th>
                        <th>Half Yearly</th>
                        <th>Quarterly</th>
                        <th>Monthly</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                @foreach($transportdata as $list)
                    <tr>
                        <td>{{$list->fcategory}}</td>
                        <td>{{$list->shtypename}}</td>
                        <td>{{$list->shannual}}</td>
                        <td>{{$list->shhalf}}</td>
                        <td>{{$list->shquater}}</td>
                        <td>{{$list->shmonthly}}</td>

                        <td>
                            <a href="{{url('admin/fees/addschedule')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/fees/schedule/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach

                     
                   
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