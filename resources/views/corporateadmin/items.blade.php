@extends('corporateadmin/layout')
@section('title','Infrastructure Items') 
@section('dashboard_select','active extra') 
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

<a href="{{url('corporateadmin/infrastructure/items/additems')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>

<div class="row">
    <div class="col-md-12">
           <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Items</th>
                        <th>Allocation</th>
                         <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $list)
                    <tr>
                        <td>{{$list->infraitem}}</td>
                         <td>
                             @if($list->allocation==1)
                             YES
                             @else
                             NO
                             @endif
                         </td>
                         <td>
                            @if($list->id==2)
                            <button class="btn btn-secondary btn-sm" disabled>Edit</button>
                            @else
                            <a href="{{url('corporateadmin/infrastructure/items/additems')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
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