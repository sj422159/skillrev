@extends('admin/layout')
@section('title','Regular Fees Schedule')
@section('manager_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
 <div class="row" >
          <div class="col-12">
            <div class="card" style="margin-top:10px">
     <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Bus Route</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                @foreach($data as $list)
                    <tr>  
                        <td>{{$list->busroute}}</td>
                        <td>
                        @if($list->moneystatus==1)
                        <button type="button" class="btn btn-success">Completed</button>
                        @elseif($list->moneystatus==0)
                        <button type="button" class="btn btn-primary">Incomplete</button>
                        @endif
                        </td>
                        <td>
                        @if($list->moneystatus==1)
                        <a href="{{url('admin/transport/fees/schedule/busroutes/location')}}/{{$list->moneystatus}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                        </a>
                        @elseif($list->moneystatus==0)
                        <a href="{{url('admin/transport/fees/schedule/busroutes/location')}}/{{$list->moneystatus}}/{{$list->id}}"><button type="button" class="btn btn-primary">Add</button>
                        </a>
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