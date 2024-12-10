@extends('admin/layout')
@section('title','Distance')
@section('manager_select','active')
@section('container')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
<div class="row"> 
        <form action="{{url('admin/fees/distance/upload')}}" enctype="multipart/form-data" method="post" class="col-12" id="Form1"> @csrf     
            <div class="form-row mt-4">
                <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Download :</label><br>
                    <a href="{{url('studentdetails/transport.xlsx')}}" class="btn btn-primary btn-sm">Sample Excel Sheet</a>  
                </div>
                <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                <label>Bus Routes :</label>
                <select class="form-control" name="busrouteid" required id="topbranch">
                <option value="">Select</option>
                @foreach($busroutes as $list)
                <option value="{{$list->id}}">{{$list->busroute}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Upload :</label>
                    <input type="file" class="form-control" name='excel' id="file" required="true">
                </div>
                <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                    <label>Action :</label><br>
                    <button type="submit" class="btn btn-success" id="submit" form="Form1">Upload</button>
                </div>
            </div>
        </form>             
</div>

<div class="row">  
        
    <div class="col-md-12">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100% ">
                <thead>
                    <tr>
                        <th>Bus Route</th>
                        <th>Pick/Drop Location</th>
                        <th>Distance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($data as $list)
                    <tr>
                        <td>{{$list->busroute}}</td>
                        <td>{{$list->location}}</td>
                        <td>{{$list->distance}} Km</td>
                        <td>
                         @if($list->disstatus==1)
                          <a href="{{url('admin/fees/distance/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary ">Active</button></a>
                        @elseif($list->disstatus==0)
                           <a href="{{url('admin/fees/distance/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-warning ">Deactive</button></a>
                        @endif
                        </td>
                        <td>
                            <a href="{{url('admin/fees/adddistance')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/fees/distance/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
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