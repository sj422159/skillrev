@extends('admin/layout')
@section('title','Fees Category')
@section('manager_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<a href="{{url('admin/fees/addcategory')}}">
<button type="button" class="btn btn-primary">Add Category</button>  </a>
<div class="row">
    <div class="col-md-12">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Name</th>
                        <th>Selection Type</th>
                        <th>Category Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach($data as $list)
                    <tr>
                       
                        <td>{{$list->fcategory}}</td>
                        <td>
                        @if($list->fctype=="1")
                          CLASS
                        @else
                          PICKUP/DROP LOCATION 
                        @endif
                       </td>
                       <td>
                        @if($list->fcmandatoryornot=="1")
                          MANDATORY
                        @else
                          OPTIONAL
                        @endif
                       </td>
                        <td>
                         @if($list->fcstatus==1)
                          <a href="{{url('admin/fees/category/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary ">Active</button></a>
                        @elseif($list->fcstatus==0)
                           <a href="{{url('admin/fees/category/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-warning ">Deactive</button></a>
                        @endif
                        </td>
                        <td>
                            <a href="{{url('admin/fees/addcategory')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/fees/category/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
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
    $('#example2').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>
@endsection