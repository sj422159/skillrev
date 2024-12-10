@extends('admin/layout')
@section('title','Distance')
@section('manager_select','active')
@section('container')
<style type="text/css">
    td,th{
        font-size: 12px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<a href="{{url('admin/fees/adddiscount')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>
<div class="row">
    <div class="col-md-12">
             <div class="table-responsive table" style="padding:20px">
        <table id="example1" class="display nowrap" style="width:100%   ">
                <thead>
                    <br>
                    <tr>
                        <th>Profile</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Fees</th>
                        <th>Discount</th>
                        <th>Total Fees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($data as $list)
                    <tr>
                        <td><img src="{{asset('studentimages')}}/{{$list->image}}" alt="User Avatar" style="height:30x !important;width: 50px;"></td>
                        <td>{{$list->sname}}</td>
                        <td>{{$list->categories}}</td>
                        <td>Sec {{$list->section}}</td>
                        <td>{{$list->fcategory}}</td>
                        <td>{{$list->disname}}</td>
                        <td>{{$list->fees}}</td>
                        <td>{{$list->dis}}%</td>
                        <td>{{$list->disprice}}</td>

                        <td>
                            <a href="{{url('admin/fees/adddiscount')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/fees/discount/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
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